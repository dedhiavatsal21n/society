<?php

namespace Astrotri\Society\Controller\Adminhtml\Society;

class NewAction extends AbstractSociety
{
	public function execute()
	{
		return $this->_forward('edit');
	}
}