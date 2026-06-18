<?php

namespace Astrotri\Society\Model;

use Magento\Framework\Model\AbstractModel;
use Astrotri\Society\Model\ResourceModel\Society as ResourceModel;

class Society extends AbstractModel
{
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE   = 1;

	protected function _construct()
	{
		$this->_init(ResourceModel::class);
	}

	/**
	 * Get available status options
	 *
	 * @return array
	 */
	public static function getStatusOptions()
	{
		return [
			self::STATUS_ACTIVE   => __('Active'),
			self::STATUS_INACTIVE => __('Inactive')
		];
	}
}
