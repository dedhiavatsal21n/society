<?php

namespace Astrotri\Society\Api;

interface TowerManagementInterface
{
    /**
     * Get towers by society
     *
     * @param int $societyId
     * @return array
     */
    public function getTowersBySociety($societyId);
}