<?php

namespace Astrotri\OtpRegistration\Api;

interface OtpManagementInterface
{

    /**
     * Send OTP
     *
     * @param string $mobile
     * @param string $flag
     * @return \Astrotri\OtpRegistration\Api\Data\ApiResponseInterface
     */
    public function sendOtp($mobile,$flag);


    /**
     * Verify OTP and Create Customer
     *
     * @param string $mobile
     * @param string $otp
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @return \Astrotri\OtpRegistration\Api\Data\ApiResponseInterface
     */
    public function otpRegistration(
        $mobile,
        $otp,
        $firstname,
        $lastname,
        $email,
        $password =null
    );

    /**
     * Verify OTP and Login
     *
     * @param string $mobile
     * @param string $otp
     * @return \Astrotri\OtpRegistration\Api\Data\ApiResponseInterface
     */
    public function otpLogin($mobile, $otp);
}