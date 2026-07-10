<?php

namespace Astrotri\OtpRegistration\Model\ResourceModel\UserOnboardRequest;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Astrotri\OtpRegistration\Model\UserOnboardRequest::class,
            \Astrotri\OtpRegistration\Model\ResourceModel\UserOnboardRequest::class
        );
    }
}