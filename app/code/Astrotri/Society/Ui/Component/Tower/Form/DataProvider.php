<?php

namespace Astrotri\Society\Ui\Component\Tower\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Astrotri\Society\Model\ResourceModel\Tower\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
	protected $loadedData;

	protected $collection;

	public function __construct(
		$name,
		$primaryFieldName,
		$requestFieldName,
		CollectionFactory $collectionFactory,
		array $meta = [],
		array $data = []
	){
		$this->collection = $collectionFactory->create();
		parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
	}

	public function getData()
	{
		if (isset($this->loadedData)) {
			return $this->loadedData;
		}

		$items = $this->collection->getItems();
		foreach ($items as $item) {
			$this->loadedData[$item->getId()]['admin_tower_form'] = $item->getData();
		}

		return $this->loadedData;
	}
}