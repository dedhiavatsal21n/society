<?php

namespace Astrotri\Society\Controller\Adminhtml\Flat;

class NewAction extends AbstractFlat
{
	public function execute()
	{
		return $this->_forward('edit');
	}
}