<?php

namespace Astrotri\Society\Block\Adminhtml\Flat;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ResetButton implements ButtonProviderInterface 
{

	public function getButtonData()
	{
		return [
			'label' => __('Reset'),
			'class' => 'reset',
			'on_click' => 'javascript: location.reload();',
			'sort_order' => 30
		];
	}
}