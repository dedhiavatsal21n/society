<?php

namespace Astrotri\Society\Model\Flat\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class OccupancyOptions implements OptionSourceInterface
{
	public function toOptionArray()
	{
		return [
			['value' => '', 'label' => __('Please Select Occupancy')],
			['value' => '1', 'label' => __('Active')],
			['value' => '2', 'label' => __('In Active')],
		];
	}
}