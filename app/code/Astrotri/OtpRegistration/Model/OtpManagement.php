<?php

namespace Astrotri\OtpRegistration\Model;

use Astrotri\OtpRegistration\Api\OtpManagementInterface;
use Astrotri\OtpRegistration\Helper\Data as OtpHelper;
use Astrotri\OtpRegistration\Model\ApiResponseData;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Model\Oauth\TokenFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Event\ManagerInterface;
use Astrotri\OtpRegistration\Api\Data\OnboardRequestInterface;



class OtpManagement implements OtpManagementInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var AccountManagementInterface
     */
    protected $accountManagement;

    /**
     * @var CustomerInterfaceFactory
     */
    protected $customerInterfaceFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var TokenFactory
     */
    protected $tokenFactory;

    /**
     * @var OtpHelper
     */
    protected $otpHelper;

    /**
     * @var ApiResponseData
     */
    protected $apiResponse;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    protected $eventManager;

    /**
     * Constructor
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $accountManagement,
        CustomerInterfaceFactory $customerInterfaceFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        TokenFactory $tokenFactory,
        OtpHelper $otpHelper,
        ApiResponseData $apiResponse,
        StoreManagerInterface $storeManager,
        ManagerInterface $eventManager
    ) {
        $this->customerRepository = $customerRepository;
        $this->accountManagement = $accountManagement;
        $this->customerInterfaceFactory = $customerInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->tokenFactory = $tokenFactory;
        $this->otpHelper = $otpHelper;
        $this->apiResponse = $apiResponse;
        $this->storeManager = $storeManager;
        $this->eventManager = $eventManager;
    }

    /**
     * Send OTP
     */
    public function sendOtp($mobile, $flag)
    {
        if($flag==''){
            return $this->apiResponse->error(
                __('Invalid Request.')
            );
        }
        if($flag=='login'){
            $checkCustomer=$this->getCustomerByMobile($mobile);
            if(!$checkCustomer){
                return $this->apiResponse->error(
                    __('Mobile number does not exist.')
                );
            }    
        }
        return $this->otpHelper->sendOtp($mobile, $flag);
    }

    /**
     * Customer Registration using OTP
     */
    public function otpRegistration(
        $mobile,
        $otp,
        $firstname,
        $lastname,
        $email,
        $password = null,
        ?OnboardRequestInterface $onboardRequest = null
    ) {

        try {
            /* check existing customer by mobile*/
            $existingCustomer = $this->getCustomerByMobile($mobile);

            if ($existingCustomer) {
                return $this->apiResponse->error(
                    __('Mobile number already registered. Please login.')
                );
            }

            /* verify OTP*/
            $result = $this->otpHelper->verifyOtp($mobile, $otp);

            if (!$result) {
                return $this->apiResponse->error(
                    __('OTP expired or invalid')
                );
            }

            /* generate random password if empty*/
            if (!$password) {
                $password = $this->generateRandomPassword();
            }

            /* create customer object*/
            $customer = $this->customerInterfaceFactory->create();

            $customer->setFirstname($firstname);
            $customer->setLastname($lastname);
            $customer->setEmail($email);

            $customer->setWebsiteId(
                $this->storeManager->getStore()->getWebsiteId()
            );

            /* save mobile custom attribute*/
            $customer->setCustomAttribute('mobile_no', $mobile);

            /* create account*/
            $createdCustomer = $this->accountManagement->createAccount(
                $customer,
                $password
            );

            /* optional login audit*/
            //$this->otpHelper->saveLoginAuditLog('OTP',$mobile,'success',null,'registration');

            // Prepare event data

            /*$eventData = new DataObject([
                'customer_id'  => $createdCustomer->getId(),
                'society_id'   => $societyId,
                'tower_id'     => $towerId,
                'flat_id'      => $flatId,
                'relation'     => $relation,
                'move_in_date' => $moveInDate,
                'move_out_date'=> $moveOutDate
            ]);*/

            // Dispatch custom event
            $this->eventManager->dispatch(
                'customer_otp_registration_success',
                [
                    'customer' => $createdCustomer,
                    'onboard_request' => $onboardRequest
                ]
            );

            return $this->apiResponse->success(
                __('Customer Created Successfully')
            );

        } catch (\Exception $e) {

            return $this->apiResponse->error(
                $e->getMessage()
            );
        }
    }

    /**
     * OTP Login
     */
    public function otpLogin($mobile, $otp){
        try 
        {
            /* Check lock*/
            if ($this->otpHelper->isMobileLocked($mobile)) {
                return $this->apiResponse->error(
                    __('Blocked : Too many failed attempts. Try again later.')
                );
            }

            /* Verify OTP*/
            $result = $this->otpHelper->verifyOtp($mobile, $otp);
            if (!$result) {
                $this->otpHelper->increaseFailure($mobile);
                //$this->otpHelper->saveLoginAuditLog('OTP',$mobile,'failed','OTP expired or invalid','login');
                return $this->apiResponse->error(
                    __('OTP expired or invalid')
                );
            }

            /* get customer by mobile*/
            $customer = $this->getCustomerByMobile($mobile);
            if (!$customer) {
                return $this->apiResponse->error(
                    __('Customer not found')
                );
            }

            /* generate customer token*/
            $token = $this->tokenFactory
                ->create()
                ->createCustomerToken($customer->getId())
                ->getToken();

            /* save success audit log*/
            //$this->otpHelper->saveLoginAuditLog('OTP',$mobile,'success',null,'login');
            return $this->apiResponse->success($token);
        } catch (\Exception $e) {

            //$this->otpHelper->saveLoginAuditLog('OTP',$mobile,'failed',$e->getMessage(),'login');

            return $this->apiResponse->error(
                $e->getMessage()
            );
        }
    }

    /**
     * Get Customer By Mobile Number
     */
    private function getCustomerByMobile($mobile)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('mobile_no', $mobile, 'eq')
            ->create();

        $customers = $this->customerRepository
            ->getList($searchCriteria)
            ->getItems();

        if (!empty($customers)) {
            return current($customers);
        }
        return false;
    }


    public function generateRandomPassword($length = 12)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $digits = '0123456789';
        $special = '@#$%&*!';

        // Ensure at least one character from each required class
        $password  = $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $digits[random_int(0, strlen($digits) - 1)];
        $password .= $special[random_int(0, strlen($special) - 1)];

        // Combine all characters
        $allCharacters = $uppercase . $lowercase . $digits . $special;

        // Fill remaining length
        for ($i = strlen($password); $i < $length; $i++) {
            $password .= $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }

        // Shuffle password
        return str_shuffle($password);
    }
}