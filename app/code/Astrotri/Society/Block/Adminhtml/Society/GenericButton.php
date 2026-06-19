<?php

namespace Astrotri\Society\Block\Adminhtml\Society;

use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Context;
use Magento\Search\Controller\RegistryConstants;

class GenericButton {

	protected $urlBuilder;

	protected $registry;

	public function __construct(Context $context, Registry $registry)
	{
		$this->urlBuilder = $context->getUrlBuilder();
		$this->registry = $registry;
	}

	public function getId()
	{
		$society = $this->registry->registry('astrotri_society');
		return $society ? $society->getSocietyId() : null;
	}

	public function getUrl($route = '', $params = [])
	{
		return $this->urlBuilder->getUrl($route, $params);
	}
}