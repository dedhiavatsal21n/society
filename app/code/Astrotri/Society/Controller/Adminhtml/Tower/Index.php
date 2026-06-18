<?php

namespace Astrotri\Society\Controller\Adminhtml\Tower;

use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Index extends AbstractSociety
{
	protected $resultPageFactory;

	public function __construct(Context $context, PageFactory $resultPageFactory)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('Astrotri_Society::manage_tower');
		$resultPage->addBreadcrumb(__('Society Management'), __('Manage Societies Tower'));
		$resultPage->getConfig()->getTitle()->prepend(__('Manage Societies Tower'));

		return $resultPage;
	}
}