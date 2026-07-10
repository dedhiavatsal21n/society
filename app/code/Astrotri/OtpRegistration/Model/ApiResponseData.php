<?php
namespace Astrotri\OtpRegistration\Model;

use Astrotri\OtpRegistration\Api\Data\ApiResponseInterfaceFactory;
use Magento\Framework\Webapi\Rest\Response;

class ApiResponseData
{
    protected $responseFactory;
    protected $response;

    public function __construct(
        ApiResponseInterfaceFactory $responseFactory,
        Response $response
    ){
        $this->responseFactory = $responseFactory;
        $this->response = $response;
    }
    public function success($message = '', $data = [])
    {
        $response = $this->responseFactory->create();

        $response->setSuccess(true);
        $response->setMessage($message);
        $response->setCustomData($data);

        $this->response->setHttpResponseCode(200);

        return $response;
    }

    public function error($message = '')
    {
        $response = $this->responseFactory->create();

        $response->setSuccess(false);
        $response->setMessage($message);

        $this->response->setHttpResponseCode(400);

        return $response;
    }
}