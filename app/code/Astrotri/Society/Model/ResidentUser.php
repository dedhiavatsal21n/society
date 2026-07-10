<?php

namespace Astrotri\Society\Model;

use Magento\Framework\Model\AbstractModel;

class ResidentUser extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Astrotri\Society\Model\ResourceModel\ResidentUser::class);
    }
}