<?php

namespace Astrotri\Society\Controller\Adminhtml\Flat;

use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Astrotri\Society\Model\FlatFactory;

class Edit extends AbstractFlat
{
	protected $registry;
	
	protected $flatFactory;
	
	protected $resultPageFactory;

	public function __construct(
		Context $context,
		Registry $registry,
		FlatFactory $flatFactory,
		PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->registry = $registry;
		$this->flatFactory = $flatFactory;
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$id = $this->getRequest()->getParam('id');
		$model = $this->flatFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addErrorMessage(__('This Flat no longer exists.'));
				return $this->_redirect('*/*/');
			}
		}

		$this->registry->register('astrotri_society_flat', $model);

		return $this->resultPageFactory->create();
	}
}