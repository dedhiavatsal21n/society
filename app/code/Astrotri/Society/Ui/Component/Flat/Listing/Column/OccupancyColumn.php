<?php
namespace Astrotri\Society\Ui\Component\Flat\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Astrotri\Society\Model\Flat\Config\Source\OccupancyOptions;

class OccupancyColumn extends Column
{
	protected $occupancyOptions;

	public function __construct(
		\Magento\Framework\View\Element\UiComponent\ContextInterface $context,
		\Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
		OccupancyOptions $occupancyOptions,
		array $components = [],
		array $data = []
	) {
		$this->occupancyOptions = $occupancyOptions;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	public function prepareDataSource(array $dataSource)
	{
		if (isset($dataSource['data']['items'])) {

			$statusMap = [];
			foreach ($this->occupancyOptions->toOptionArray() as $option) {
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