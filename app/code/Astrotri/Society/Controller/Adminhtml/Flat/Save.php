<?php

namespace Astrotri\Society\Controller\Adminhtml\Flat;

use Magento\Backend\App\Action\Context;
use Astrotri\Society\Model\FlatFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends AbstractFlat
{
	protected $dataPersistor;

	protected $flatFactory;

	public function __construct(
		Context $context,
		FlatFactory $flatFactory,
		DataPersistorInterface $dataPersistor
	) {
		parent::__construct($context);
		$this->flatFactory = $flatFactory;
		$this->dataPersistor = $dataPersistor;
	}

	public function execute()
	{
		$postData = $this->getRequest()->getPostValue();
		$data = $postData['admin_flat_form'];

		if (!$data) {
			return $this->_redirect('*/*/');
		}

		$id = $data['tower_id'] ?? null;
		$model = $this->flatFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addErrorMessage(__('This Flat no longer exists.'));
				return $this->_redirect('*/*/');
			}
		}

		$model->setData($data);

		try {
			$model->save();

			$this->messageManager->addSuccessMessage(__('Flat saved successfully.'));
			$this->dataPersistor->clear('astrotri_society_flat');

			if ($this->getRequest()->getParam('back')) {
				return $this->_redirect('*/*/edit', ['id' => $model->getId()]);
			}

			return $this->_redirect('*/*/');

		} catch (\Exception $e) {

			$this->messageManager->addErrorMessage($e->getMessage());
		}

		$this->dataPersistor->set('astrotri_society_flat', $data);
		
		return $this->_redirect('*/*/edit', ['id' => $id]);
	}
}