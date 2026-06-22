<?php

namespace Astrotri\Society\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Flat extends AbstractDb
{
	protected function _construct()
	{
		$this->_init('smp_society_flat', 'flat_id');
	}
}