<?php

namespace Astrotri\OtpRegistration\Model;

use Magento\Framework\Model\AbstractModel;

class UserOnboardRequest extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(
            \Astrotri\OtpRegistration\Model\ResourceModel\UserOnboardRequest::class
        );
    }
}