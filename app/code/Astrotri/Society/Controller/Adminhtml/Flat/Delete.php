<?php

namespace Astrotri\Society\Controller\Adminhtml\Flat;

use Magento\Backend\App\Action\Context;
use Astrotri\Society\Model\FlatFactory;

class Delete extends AbstractFlat
{
	protected $flatFactory;

	public function __construct(
		Context $context,
		FlatFactory $flatFactory
	) {
		parent::__construct($context);
		$this->flatFactory = $flatFactory;
	}

	public function execute()
	{
		$id = $this->getRequest()->getParam('id');

		if ($id) {

			try {

				$model = $this->flatFactory->create()->load($id);
				$model->delete();

				$this->messageManager->addSuccessMessage(__('Flat deleted successfully.'));
				return $this->_redirect('*/*/');

			} catch (\Exception $e) {

				$this->messageManager->addErrorMessage($e->getMessage());
				return $this->_redirect('*/*/edit', ['id' => $id]);
			}
		}

		$this->messageManager->addErrorMessage(__('Unable to find Flat to delete.'));
		return $this->_redirect('*/*/');
	}
}