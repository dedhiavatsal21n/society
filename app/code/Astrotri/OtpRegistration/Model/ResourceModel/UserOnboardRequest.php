<?php

namespace Astrotri\OtpRegistration\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class UserOnboardRequest extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(
            'sp_user_onboard_request',
            'user_onboard_request_id'
        );
    }
}