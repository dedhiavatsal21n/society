<?php

namespace Astrotri\Society\Controller\Adminhtml\Tower;

use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Astrotri\Society\Model\TowerFactory;

class Edit extends AbstractTower
{
	protected $registry;
	
	protected $towerFactory;
	
	protected $resultPageFactory;

	public function __construct(
		Context $context,
		Registry $registry,
		TowerFactory $towerFactory,
		PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->registry = $registry;
		$this->towerFactory = $towerFactory;
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$id = $this->getRequest()->getParam('id');
		$model = $this->towerFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addErrorMessage(__('This Tower no longer exists.'));
				return $this->_redirect('*/*/');
			}
		}

		$this->registry->register('astrotri_society_tower', $model);

		return $this->resultPageFactory->create();
	}
}