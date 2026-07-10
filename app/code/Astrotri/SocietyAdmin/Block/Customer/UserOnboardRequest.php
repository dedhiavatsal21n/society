<?php

namespace Astrotri\SocietyAdmin\Block\Customer;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\SessionFactory;
use Astrotri\OtpRegistration\Model\ResourceModel\UserOnboardRequest\CollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;


class UserOnboardRequest extends Template
{
    private Session $customerSession;

    private CollectionFactory $collectionFactory;

    protected $customerRepository;

    private $customerSessionFactory;

    public function __construct(
        Template\Context $context,
        SessionFactory $customerSessionFactory,
        CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSessionFactory = $customerSessionFactory;
        $this->collectionFactory = $collectionFactory;
        $this->customerRepository = $customerRepository;
    }

    public function getCollection()
    {
        $session = $this->customerSessionFactory->create();

        $customerId = $session->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);
        
        $attribute = $customer->getCustomAttribute('society_id');
        $societyId = $attribute ? $attribute->getValue() : null;
        
        return $this->collectionFactory->create()
            ->addFieldToFilter(
                'society_id',
                $societyId
            )
            ->setOrder('created_at', 'DESC');
    }

    public function getActionsList()
    {
        return [
            '' => __('Select'),
            'approve' => __('Approve'),
            'reject' => __('Reject'),
            'delete' => __('Delete')
        ];
    }
}