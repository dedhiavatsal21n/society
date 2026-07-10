<?php
namespace  Astrotri\OtpRegistration\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\ResourceConnection;
use Astrotri\OtpRegistration\Model\ApiResponseData;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $scopeConfig;
    protected $resourceConnection;
    protected $logger;
    protected $apiResponse;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ResourceConnection $resource,
        ApiResponseData $apiResponse
    )
    {
        $this->scopeConfig= $scopeConfig;
        $this->resourceConnection = $resource;
        $this->apiResponse = $apiResponse;
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/sendSmsOtp.log');
        $this->logger = new \Zend_Log();
        $this->logger->addWriter($writer);
    }

    public function sendOtp($mobile,$flag)
    {

        $otp = rand(100000,999999);

        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('customer_otp');

        // OTP Rate Limit Time (minutes window)
        $rateLimitMinutes = (int) $this->scopeConfig->getValue(
            'otp_settings/general/otp_limit_minutes',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        // Maximum OTP Request allowed
        $maxOtpRequest = (int) $this->scopeConfig->getValue(
            'otp_settings/general/otp_limit_per_minute',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );


        // Default fallback values
        $maxOtpRequest = $maxOtpRequest > 0 ? $maxOtpRequest : 3;
        $rateLimitMinutes = $rateLimitMinutes > 0 ? $rateLimitMinutes : 15;


        $rateLimitSelect = $connection->select()
            ->from($table, ['count' => 'COUNT(*)'])
            ->where('mobile = ?', $mobile)
            ->where('created_at >= DATE_SUB(NOW(), INTERVAL ' . $rateLimitMinutes . ' MINUTE)');

        $requestCount = (int) $connection->fetchOne($rateLimitSelect);


        if ($requestCount >= $maxOtpRequest) {
            return $this->apiResponse->error(
                __('Maximum OTP request limit exceeded. Please try again after %1 minutes.', $rateLimitMinutes)
            );
        }

        /* GENERATE OTP */
        $connection->insert($table,[
            'mobile'=>$mobile,
            'flag'=>$flag,
            'otp'=>$otp,
            'is_used' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        /*add SMS code here*/

        return $this->apiResponse->success('OTP Sent Succesfully', ['otp'=>$otp] ) ;
    }

    public function verifyOtp($mobile,$otp)
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('customer_otp');
        
        $expiry = $this->scopeConfig->getValue('otp_settings/general/otp_expiry',ScopeInterface::SCOPE_STORE);

        if (!$expiry) {
            $expiry = 5;
        }

        $select = $connection->select()
            ->from($table)
            ->where('mobile = ?', $mobile)
            ->where('otp = ?', $otp)
            ->where('is_used = ?', 0)
            ->where('created_at >= DATE_SUB(NOW(), INTERVAL ' . $expiry . ' MINUTE)')
            ->order('entity_id DESC')
            ->limit(1);

        $result = $connection->fetchRow($select);

        if($result){
            // Mark OTP as used
            $connection->update(
                $table,
                ['is_used' => 1],
                ['entity_id = ?' => $result['entity_id']]
            );
        }

        return (bool) $result;
    }

    public function isMobileLocked($mobile)
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('otp_login');

        $select = $connection->select()
            ->from($table)
            ->where('mobile = ?', $mobile)
            ->limit(1);

        $row = $connection->fetchRow($select);

        if (!$row) {
            return false;
        }

        if ($row['lock_expire'] && strtotime($row['lock_expire']) > time()) {
            return true;
        }

        return false;
    }

    public function increaseFailure($mobile)
    {
        $locktime = (int) $this->scopeConfig->getValue(
            'otp_settings/general/otp_failure_lock_time',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $locktime = $locktime > 0 ? $locktime : 5;

        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('otp_login');

        $select = $connection->select()
            ->from($table)
            ->where('mobile = ?', $mobile)
            ->limit(1);

        $row = $connection->fetchRow($select);

        if (!$row) {

            $connection->insert($table, [
                'mobile' => $mobile,
                'failure' => 1
            ]);

            return;
        }

        $failure = $row['failure'] + 1;

        $data = ['failure' => $failure];

        if ($failure >= 5) {
            $data['lock_expire'] = date('Y-m-d H:i:s', strtotime('+'.$locktime.' minutes'));
        }

        $connection->update(
            $table,
            $data,
            ['mobile = ?' => $mobile]
        );
    }


}
