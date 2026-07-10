<?php

namespace Astrotri\OtpRegistration\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Astrotri\OtpRegistration\Api\Data\OnboardRequestInterface;
use Astrotri\OtpRegistration\Api\Data\OnboardRequestExtensionInterface;

class OnboardRequest extends AbstractExtensibleObject implements OnboardRequestInterface
{
    public function getSocietyId()
    {
        return $this->_get('society_id');
    }

    public function setSocietyId($societyId)
    {
        return $this->setData('society_id', $societyId);
    }

    public function getTowerId()
    {
        return $this->_get('tower_id');
    }

    public function setTowerId($towerId)
    {
        return $this->setData('tower_id', $towerId);
    }

    public function getFlatId()
    {
        return $this->_get('flat_id');
    }

    public function setFlatId($flatId)
    {
        return $this->setData('flat_id', $flatId);
    }

    public function getRelation()
    {
        return $this->_get('relation');
    }

    public function setRelation($relation)
    {
        return $this->setData('relation', $relation);
    }

    public function getMoveInDate()
    {
        return $this->_get('move_in_date');
    }

    public function setMoveInDate($moveInDate)
    {
        return $this->setData('move_in_date', $moveInDate);
    }

    public function getMoveOutDate()
    {
        return $this->_get('move_out_date');
    }

    public function setMoveOutDate($moveOutDate)
    {
        return $this->setData('move_out_date', $moveOutDate);
    }

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    public function setExtensionAttributes(
        OnboardRequestExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}