<?php

namespace Astrotri\Society\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Society extends AbstractDb
{
	protected function _construct()
	{
		$this->_init('smp_society', 'society_id');
	}
}