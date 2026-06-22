<?php

namespace Astrotri\Society\Model\Society\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class StatusOptions implements OptionSourceInterface
{
	public function toOptionArray()
	{
		return [
			['value' => '', 'label' => __('Please Select Status')],
			['value' => '1', 'label' => __('Active')],
			['value' => '2', 'label' => __('In Active')],
		];
	}
}