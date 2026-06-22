<?php
namespace Astrotri\Society\Ui\Component\Society\Listing;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Astrotri\Society\Model\ResourceModel\Society\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
	public function __construct(
		$name,
		$primaryFieldName,
		$requestFieldName,
		CollectionFactory $collectionFactory,
		array $meta = [],
		array $data = []
	) {
		$this->collection = $collectionFactory->create();
		parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
	}
}