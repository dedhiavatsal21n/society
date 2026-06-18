<?php

namespace Astrotri\OtpRegistration\Api\Data;

interface ApiResponseInterface
{
    /**
     * Get success flag
     *
     * @return bool
     */
    public function getSuccess();

    /**
     * Set success flag
     *
     * @param bool $success
     * @return $this
     */
    public function setSuccess($success);

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);

    /**
     * Get response data
     *
     * @return mixed[]
     */
    public function getCustomData();

    /**
     * Set response data
     *
     * @param mixed[] $data
     * @return $this
     */
    public function setCustomData($data);
}