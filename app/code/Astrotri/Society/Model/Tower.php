<?php

namespace Astrotri\Society\Model;

use Magento\Framework\Model\AbstractModel;
use Astrotri\Society\Model\ResourceModel\Tower as ResourceModel;

class Tower extends AbstractModel
{
	protected function _construct()
	{
		$this->_init(ResourceModel::class);
	}
}