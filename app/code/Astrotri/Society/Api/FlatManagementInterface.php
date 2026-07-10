<?php

namespace Astrotri\Society\Api;

interface FlatManagementInterface
{
    /**
     * Get flats by tower
     *
     * @param int $towerId
     * @return array
     */
    public function getFlatsByTower($towerId);
}