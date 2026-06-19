<?php

namespace Astrotri\Society\Block\Adminhtml\Flat;

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
		$flat = $this->registry->registry('astrotri_society_flat');
		return $flat ? $flat->getFlatId() : null;
	}

	public function getUrl($route = '', $params = [])
	{
		return $this->urlBuilder->getUrl($route, $params);
	}
}