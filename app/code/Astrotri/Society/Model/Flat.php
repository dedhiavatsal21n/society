<?php

namespace Astrotri\Society\Model;

use Magento\Framework\Model\AbstractModel;
use Astrotri\Society\Model\ResourceModel\Flat as ResourceModel;

class Flat extends AbstractModel
{
	const OCCUPANCY_STATUS_VACANT  = 0;
	const OCCUPANCY_STATUS_OCCUPIED = 1;

	const OWNERSHIP_TYPE_OWNER  = 0;
	const OWNERSHIP_TYPE_RENTED = 1;

	protected function _construct()
	{
		$this->_init(ResourceModel::class);
	}

	/**
	 * Get occupancy status options
	 *
	 * @return array
	 */
	public static function getOccupancyStatusOptions()
	{
		return [
			self::OCCUPANCY_STATUS_VACANT  	=> __('Vacant'),
			self::OCCUPANCY_STATUS_OCCUPIED => __('Occupied')
		];
	}

	/**
	 * Get ownership status options
	 *
	 * @return array
	 */
	public static function getOwnershipTypeOptions()
	{
		return [
			self::OWNERSHIP_TYPE_OWNER  => __('Owner'),
			self::OWNERSHIP_TYPE_RENTED => __('Rented')
		];
	}
}