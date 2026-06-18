<?php

namespace Astrotri\OtpRegistration\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface OnboardRequestInterface extends ExtensibleDataInterface
{
    const SOCIETY_ID = 'society_id';
    const TOWER_ID = 'tower_id';
    const FLAT_ID = 'flat_id';
    const RELATION = 'relation';
    const MOVE_IN_DATE = 'move_in_date';
    const MOVE_OUT_DATE = 'move_out_date';

    /**
     * @return int|null
     */
    public function getSocietyId();

    /**
     * @param int $societyId
     * @return $this
     */
    public function setSocietyId($societyId);

    /**
     * @return int|null
     */
    public function getTowerId();

    /**
     * @param int $towerId
     * @return $this
     */
    public function setTowerId($towerId);

    /**
     * @return int|null
     */
    public function getFlatId();

    /**
     * @param int $flatId
     * @return $this
     */
    public function setFlatId($flatId);

    /**
     * @return string|null
     */
    public function getRelation();

    /**
     * @param string $relation
     * @return $this
     */
    public function setRelation($relation);

    /**
     * @return string|null
     */
    public function getMoveInDate();

    /**
     * @param string $moveInDate
     * @return $this
     */
    public function setMoveInDate($moveInDate);

    /**
     * @return string|null
     */
    public function getMoveOutDate();

    /**
     * @param string $moveOutDate
     * @return $this
     */
    public function setMoveOutDate($moveOutDate);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Astrotri\OtpRegistration\Api\Data\OnboardRequestExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Astrotri\OtpRegistration\Api\Data\OnboardRequestExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Astrotri\OtpRegistration\Api\Data\OnboardRequestExtensionInterface $extensionAttributes
    );
}