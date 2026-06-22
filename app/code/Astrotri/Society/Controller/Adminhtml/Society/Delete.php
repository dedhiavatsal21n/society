<?php

namespace Astrotri\Society\Controller\Adminhtml\Society;

use Magento\Backend\App\Action\Context;
use Astrotri\Society\Model\SocietyFactory;

class Delete extends AbstractSociety
{
	protected $societyFactory;

	public function __construct(
		Context $context,
		SocietyFactory $societyFactory
	) {
		parent::__construct($context);
		$this->societyFactory = $societyFactory;
	}

	public function execute()
	{
		$id = $this->getRequest()->getParam('id');

		if ($id) {

			try {

				$model = $this->societyFactory->create()->load($id);
				$model->delete();

				$this->messageManager->addSuccessMessage(__('Society deleted successfully.'));
				return $this->_redirect('*/*/');

			} catch (\Exception $e) {

				$this->messageManager->addErrorMessage($e->getMessage());
				return $this->_redirect('*/*/edit', ['id' => $id]);
			}
		}

		$this->messageManager->addErrorMessage(__('Unable to find Society to delete.'));
		return $this->_redirect('*/*/');
	}
}