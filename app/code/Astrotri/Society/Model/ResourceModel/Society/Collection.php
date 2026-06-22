<?php

namespace Astrotri\Society\Model\ResourceModel\Society;

use Astrotri\Society\Model\Society as Model;
use Astrotri\Society\Model\ResourceModel\Society as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	/**
	 * Primary field name
	 *
	 * @var string
	 */
	protected $_idFieldName = 'society_id';

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