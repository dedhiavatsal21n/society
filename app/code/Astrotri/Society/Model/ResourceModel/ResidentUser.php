<?php

namespace Astrotri\Society\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ResidentUser extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sp_resident_user', 'ru_id');
    }
}