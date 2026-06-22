<?php

namespace Astrotri\Society\Model;

use Astrotri\Society\Api\TowerManagementInterface;
use Astrotri\Society\Model\ResourceModel\Tower\CollectionFactory;

class TowerManagement implements TowerManagementInterface
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

    public function getTowersBySociety($societyId)
    {
        return $this->collectionFactory
            ->create()
            ->addFieldToFilter('society_id', $societyId)
            ->getData();
    }
}