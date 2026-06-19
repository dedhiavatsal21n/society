<?php

namespace Astrotri\Society\Controller\Adminhtml\Tower;

use Magento\Backend\App\Action\Context;
use Astrotri\Society\Model\TowerFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends AbstractTower
{
	protected $dataPersistor;

	protected $towerFactory;

	public function __construct(
		Context $context,
		TowerFactory $towerFactory,
		DataPersistorInterface $dataPersistor
	) {
		parent::__construct($context);
		$this->towerFactory = $towerFactory;
		$this->dataPersistor = $dataPersistor;
	}

	public function execute()
	{
		$postData = $this->getRequest()->getPostValue();
		$data = $postData['admin_tower_form'];

		if (!$data) {
			return $this->_redirect('*/*/');
		}

		$id = $data['tower_id'] ?? null;
		$model = $this->towerFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addErrorMessage(__('This Tower no longer exists.'));
				return $this->_redirect('*/*/');
			}
		}

		$model->setData($data);

		try {
			$model->save();

			$this->messageManager->addSuccessMessage(__('Tower saved successfully.'));
			$this->dataPersistor->clear('astrotri_society_tower');

			if ($this->getRequest()->getParam('back')) {
				return $this->_redirect('*/*/edit', ['id' => $model->getId()]);
			}

			return $this->_redirect('*/*/');

		} catch (\Exception $e) {

			$this->messageManager->addErrorMessage($e->getMessage());
		}

		$this->dataPersistor->set('astrotri_society_tower', $data);
		
		return $this->_redirect('*/*/edit', ['id' => $id]);
	}
}