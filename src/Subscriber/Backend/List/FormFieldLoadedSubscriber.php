<?php

namespace Smug\FrontendFormBundle\Subscriber\Backend\List;

use Smug\AdministrationBundle\Event\SystemEvents;
use Smug\Core\DataAbstractionLayer\EntityGenerator;
use Smug\Core\Events\Backend\Data\DataModelLoadedEvent;
use Smug\Core\Service\Base\Components\Handler\DataHandler;
use Smug\FrontendFormBundle\Entity\Form\Form;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormFieldLoadedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            SystemEvents::DATA_MODEL_LOADED => 'onFieldLoaded'
        ];
    }

    public function onFieldLoaded(DataModelLoadedEvent $event): void
    {
        if ($event->getClass() === EntityGenerator::getGeneratedEntity(Form::class)) {
            $data = $event->getData();

            $data['fields'] = DataHandler::sortItemsByField($data['fields'], 'position');

            foreach ($data['fields'] as $fieldKey => $field) {

                if (DataHandler::doesKeyExists('values', $field['fieldConfiguration'])) {
                    $data['fields'][$fieldKey]['fieldConfiguration']['values'] = DataHandler::sortItemsByField($field['fieldConfiguration']['values'], 'position');
                }

                foreach ($field['children'] ?? [] as $childKey => $child) {
                    if (DataHandler::doesKeyExists('values', $child['fieldConfiguration'])) {
                        $data['fields'][$fieldKey]['children'][$childKey]['fieldConfiguration']['values'] = DataHandler::sortItemsByField($child['fieldConfiguration']['values'], 'position');
                    }
                }
            }
            
            $event->setData($data);
        }
    }
}