<?php

namespace Astrotri\Society\Model;

use Astrotri\Society\Api\FlatManagementInterface;
use Astrotri\Society\Model\ResourceModel\Flat\CollectionFactory;

class FlatManagement implements FlatManagementInterface
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

    public function getFlatsByTower($towerId)
    {
        return $this->collectionFactory
            ->create()
            ->addFieldToFilter('tower_id', $towerId)
            ->getData();
    }
}