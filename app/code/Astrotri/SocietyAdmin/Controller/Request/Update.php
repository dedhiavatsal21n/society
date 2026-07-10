<?php

namespace Astrotri\SocietyAdmin\Controller\Request;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Astrotri\OtpRegistration\Model\UserOnboardRequestFactory;
use Astrotri\Society\Model\ResidentUserFactory;


class Update implements HttpPostActionInterface
{
    private $request;
    protected $resultJsonFactory;
    protected $requestFactory;

    public function __construct(
        JsonFactory $resultJsonFactory,
        RequestInterface $request,
        UserOnboardRequestFactory $requestFactory,
        ResidentUserFactory $residentUserFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        $this->requestFactory = $requestFactory;
        $this->residentUserFactory = $residentUserFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        try {

            $requestId = (int)$this->request->getParam('request_id');
            $action = $this->request->getParam('action');

            $model = $this->requestFactory->create()->load($requestId);

            if (!$model->getId()) {
                throw new \Exception(__('Request not found.'));
            }

            switch ($action) {

                case 'approve':
                    $model->setStatus('approved');
                    $model->save();
                    break;

                case 'reject':
                    $model->setStatus('rejected');
                    $model->save();
                    break;

                case 'delete':
                    $model->delete();
                    break;

                default:
                    throw new \Exception(__('Invalid action.'));
            }

            return $result->setData([
                'success' => true,
                'message' => __('Action completed successfully.')
            ]);

        } catch (\Exception $e) {

            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}