<?php

namespace Astrotri\Society\Model\ResourceModel\Flat;

use Astrotri\Society\Model\Flat as Model;
use Astrotri\Society\Model\ResourceModel\Flat as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	/**
	 * Primary field name
	 *
	 * @var string
	 */
	protected $_idFieldName = 'flat_id';

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