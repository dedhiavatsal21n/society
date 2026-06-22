<?php

namespace Astrotri\Society\Controller\Adminhtml\Tower;

class NewAction extends AbstractTower
{
	public function execute()
	{
		return $this->_forward('edit');
	}
}