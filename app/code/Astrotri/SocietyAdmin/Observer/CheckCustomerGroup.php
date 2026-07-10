<?php

namespace Astrotri\SocietyAdmin\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CheckCustomerGroup implements ObserverInterface
{
    private Session $customerSession;

    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        Session $customerSession,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer)
    {
        $allowedGroupId = (int)$this->scopeConfig->getValue(
            'societyadmin/login_settings/allowed_customer_group'
        );
        $customer = $observer->getEvent()->getCustomer();

        if ((int)$customer->getGroupId() !== $allowedGroupId) {
            $this->customerSession->logout();

            throw new LocalizedException(
                __('You are not authorized to log in.')
            );
        }
    }
}