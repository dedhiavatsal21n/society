<?php

namespace Astrotri\Society\Api;

interface SocietyManagementInterface
{
    /**
     * Get societies
     *
     * @param string|null $country
     * @param string|null $state
     * @param string|null $city
     * @param string|null $search
     * @return array
     */
    public function getSocieties(
        $country = null,
        $state = null,
        $city = null,
        $search = null
    );
}