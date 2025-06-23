<?php

namespace Smug\FrontendFormBundle\Subscriber\Backend\List;

use Smug\FrontendBundle\Event\Data\ApiEndpointsLoadedEvent;
use Smug\FrontendBundle\Event\FrontendEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ApiEndpointsLoadedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FrontendEvents::FRONTEND_API_ENDPOINTS_LOADED => 'onDataLoaded'
        ];
    }

    public function onDataLoaded(ApiEndpointsLoadedEvent $event): void
    {
        $data = $event->getData();

        $data[] = [
            'title' => 'DYNAMIC_CONTACT_FORM_ENDPOINT',
            'value' => '/fe/api/custom/dynamic/form'
        ];

        $event->setData($data);
    }
}