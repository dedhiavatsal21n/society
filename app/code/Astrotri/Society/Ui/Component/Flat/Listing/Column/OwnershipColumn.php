<?php
namespace Astrotri\Society\Ui\Component\Flat\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Astrotri\Society\Model\Flat\Config\Source\OwnershipOptions;

class OwnershipColumn extends Column
{
	protected $ownershipOptions;

	public function __construct(
		\Magento\Framework\View\Element\UiComponent\ContextInterface $context,
		\Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
		OwnershipOptions $ownershipOptions,
		array $components = [],
		array $data = []
	) {
		$this->ownershipOptions = $ownershipOptions;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	public function prepareDataSource(array $dataSource)
	{
		if (isset($dataSource['data']['items'])) {

			$statusMap = [];
			foreach ($this->ownershipOptions->toOptionArray() as $option) {
				$statusMap[$option['value']] = $option['label'];
			}

			foreach ($dataSource['data']['items'] as & $item) {

				if (isset($item['status'])) {
					
					// Modify value
					$item[$this->getData('name')] = $statusMap[$item['status']];
				}
			}
		}
		return $dataSource;
	}
}