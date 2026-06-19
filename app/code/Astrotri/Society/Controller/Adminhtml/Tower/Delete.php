<?php

namespace Astrotri\Society\Controller\Adminhtml\Tower;

use Magento\Backend\App\Action\Context;
use Astrotri\Society\Model\TowerFactory;

class Delete extends AbstractTower
{
	protected $towerFactory;

	public function __construct(
		Context $context,
		TowerFactory $towerFactory
	) {
		parent::__construct($context);
		$this->towerFactory = $towerFactory;
	}

	public function execute()
	{
		$id = $this->getRequest()->getParam('id');

		if ($id) {

			try {

				$model = $this->towerFactory->create()->load($id);
				$model->delete();

				$this->messageManager->addSuccessMessage(__('Tower deleted successfully.'));
				return $this->_redirect('*/*/');

			} catch (\Exception $e) {

				$this->messageManager->addErrorMessage($e->getMessage());
				return $this->_redirect('*/*/edit', ['id' => $id]);
			}
		}

		$this->messageManager->addErrorMessage(__('Unable to find Tower to delete.'));
		return $this->_redirect('*/*/');
	}
}