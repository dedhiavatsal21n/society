<?php

namespace Astrotri\Society\Model\ResourceModel\ResidentUser;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Astrotri\Society\Model\ResidentUser as Model;
use Astrotri\Society\Model\ResourceModel\ResidentUser as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}