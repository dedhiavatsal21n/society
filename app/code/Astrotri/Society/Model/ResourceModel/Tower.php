<?php

namespace Astrotri\Society\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Tower extends AbstractDb
{
	protected function _construct()
	{
		$this->_init('smp_society_tower', 'tower_id');
	}
}