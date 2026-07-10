<?php

namespace Astrotri\OtpRegistration\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Astrotri\OtpRegistration\Model\UserOnboardRequestFactory;
use Astrotri\OtpRegistration\Model\ResourceModel\UserOnboardRequest as UserOnboardRequestResource;
use Psr\Log\LoggerInterface;

class CustomerRegistrationObserver implements ObserverInterface
{
    protected $userOnboardRequestFactory;

    protected $userOnboardRequestResource;

    protected $logger;

    public function __construct(
        UserOnboardRequestFactory $userOnboardRequestFactory,
        UserOnboardRequestResource $userOnboardRequestResource,
        LoggerInterface $logger
    ) {
        $this->userOnboardRequestFactory = $userOnboardRequestFactory;
        $this->userOnboardRequestResource = $userOnboardRequestResource;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {

            $customer = $observer->getData('customer');
            $onboardRequest = $observer->getData('onboard_request');

            if (!$customer || !$onboardRequest) {
                return;
            }

            $request = $this->userOnboardRequestFactory->create();

            $request->setCustomerId($customer->getId());
            $request->setSocietyId($onboardRequest->getSocietyId());
            $request->setTowerId($onboardRequest->getTowerId());
            $request->setFlatId($onboardRequest->getFlatId());
            $request->setRelation($onboardRequest->getRelation());
            $request->setMoveInDate($onboardRequest->getMoveInDate());
            $request->setMoveOutDate($onboardRequest->getMoveOutDate());
            $request->setStatus(0);

            $this->userOnboardRequestResource->save($request);

        } catch (\Exception $e) {
            $this->logger->error(
                'CustomerRegistrationObserver: ' . $e->getMessage()
            );
        }
    }
}