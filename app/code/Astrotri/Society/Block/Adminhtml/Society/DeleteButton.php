<?php

namespace Astrotri\Society\Block\Adminhtml\Society;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface 
{

	public function getButtonData()
	{
		$data = [];
		
		if ($this->getId()) {

			$data = [
				'label' => __('Delete Society'),
				'class' => 'delete',
				'on_click' => 'deleteConfirm(\''. __('Are you sure you want to delete this Society ?'). '\', \'' . $this->getDeleteUrl() . '\')',
				'sort_order' => 20,
			];

		}

		return $data;
	}

	public function getDeleteUrl()
	{
		return $this->getUrl('*/*/delete', ['id' => $this->getId()]);
	}
}