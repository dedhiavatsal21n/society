<?php

namespace Astrotri\Society\Controller\Adminhtml\Society;

use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Astrotri\Society\Model\SocietyFactory;

class Edit extends AbstractSociety
{
	protected $registry;
	
	protected $societyFactory;
	
	protected $resultPageFactory;

	public function __construct(
		Context $context,
		Registry $registry,
		SocietyFactory $societyFactory,
		PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->registry = $registry;
		$this->societyFactory = $societyFactory;
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$id = $this->getRequest()->getParam('id');
		$model = $this->societyFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addErrorMessage(__('This Society no longer exists.'));
				return $this->_redirect('*/*/');
			}
		}

		$this->registry->register('astrotri_society', $model);

		return $this->resultPageFactory->create();
	}
}