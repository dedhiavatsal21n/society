<?php
namespace Astrotri\Society\Ui\Component\Society\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Astrotri\Society\Model\Society\Config\Source\StatusOptions;

class StatusColumn extends Column
{
	protected $statusOptions;

	public function __construct(
		\Magento\Framework\View\Element\UiComponent\ContextInterface $context,
		\Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
		StatusOptions $statusOptions,
		array $components = [],
		array $data = []
	) {
		$this->statusOptions = $statusOptions;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	public function prepareDataSource(array $dataSource)
	{
		if (isset($dataSource['data']['items'])) {

			$statusMap = [];
			foreach ($this->statusOptions->toOptionArray() as $option) {
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