<?php

namespace Astrotri\OtpRegistration\Model;

use Magento\Framework\DataObject;
use Astrotri\OtpRegistration\Api\Data\ApiResponseInterface;

class ApiResponse extends DataObject implements ApiResponseInterface
{
    public function getSuccess()
    {
        return $this->getData('success');
    }

    public function setSuccess($success)
    {
        return $this->setData('success', $success);
    }

    public function getMessage()
    {
        return $this->getData('message');
    }

    public function setMessage($message)
    {
        return $this->setData('message', $message);
    }

    public function getCustomData()
    {
        return $this->getData('data');
    }

    public function setCustomData($data)
    {
        return $this->setData('data', $data);
    }
}