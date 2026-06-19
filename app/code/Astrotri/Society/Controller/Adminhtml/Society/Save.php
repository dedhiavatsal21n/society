<?php

namespace Astrotri\Society\Controller\Adminhtml\Society;

use Magento\Backend\App\Action\Context;
use Astrotri\Society\Model\SocietyFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends AbstractSociety
{
	protected $dataPersistor;

	protected $societyFactory;

	public function __construct(
		Context $context,
		SocietyFactory $societyFactory,
		DataPersistorInterface $dataPersistor
	) {
		parent::__construct($context);
		$this->dataPersistor = $dataPersistor;
		$this->societyFactory = $societyFactory;
	}

	public function execute()
	{
		$postData = $this->getRequest()->getPostValue();
		$data = $postData['admin_society_form'];

		if (!$data) {
			return $this->_redirect('*/*/');
		}

		$id = $data['society_id'] ?? null;
		$model = $this->societyFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addErrorMessage(__('This Society no longer exists.'));
				return $this->_redirect('*/*/');
			}
		}

		$model->setData($data);

		try {
			$model->save();

			$this->messageManager->addSuccessMessage(__('Society saved successfully.'));
			$this->dataPersistor->clear('astrotri_society');

			if ($this->getRequest()->getParam('back')) {
				return $this->_redirect('*/*/edit', ['id' => $model->getId()]);
			}

			return $this->_redirect('*/*/');

		} catch (\Exception $e) {

			$this->messageManager->addErrorMessage($e->getMessage());
		}

		$this->dataPersistor->set('astrotri_society', $data);
		
		return $this->_redirect('*/*/edit', ['id' => $id]);
	}
}