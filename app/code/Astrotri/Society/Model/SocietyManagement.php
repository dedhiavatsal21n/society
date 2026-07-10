<?php

namespace Astrotri\Society\Model;

use Astrotri\Society\Api\SocietyManagementInterface;
use Astrotri\Society\Model\ResourceModel\Society\CollectionFactory;

class SocietyManagement implements SocietyManagementInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function getSocieties(
        $country = null,
        $state = null,
        $city = null,
        $search = null
    ) {
        $collection = $this->collectionFactory->create();

        if ($country) {
            $collection->addFieldToFilter('country', $country);
        }

        if ($state) {
            $collection->addFieldToFilter('state', $state);
        }

        if ($city) {
            $collection->addFieldToFilter('city', $city);
        }

        if ($search) {
            $collection->addFieldToFilter(
                ['name', 'code', 'address'],
                [
                    ['like' => "%{$search}%"],
                    ['like' => "%{$search}%"],
                    ['like' => "%{$search}%"]
                ]
            );
        }

        return $collection->getData();
    }
}