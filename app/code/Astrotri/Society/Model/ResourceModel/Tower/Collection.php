<?php

namespace Astrotri\Society\Model\ResourceModel\Tower;

use Astrotri\Society\Model\Tower as Model;
use Astrotri\Society\Model\ResourceModel\Tower as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	/**
	 * Primary field name
	 *
	 * @var string
	 */
	protected $_idFieldName = 'tower_id';

	/**
	 * Initialize collection
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(Model::class, ResourceModel::class);
	}
}