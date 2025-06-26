<?php

namespace Smug\FrontendFormBundle\Subscriber\Backend\Data;

use Smug\AdministrationBundle\Event\SystemEvents;
use Smug\Core\DataAbstractionLayer\EntityGenerator;
use Smug\Core\Events\Backend\Data\DataUpdatedEvent;
use Smug\Core\Service\Base\Components\Handler\DataHandler;
use Smug\FrontendFormBundle\Entity\Form\Form;
use Smug\FrontendFormBundle\Entity\FormField\FormField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormUpdateDataSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            SystemEvents::DATA_UPDATED => 'onDataUpdated'
        ];
    }

    public function onDataUpdated(DataUpdatedEvent $event): void
    {
        if ($event->getClass() === EntityGenerator::getGeneratedEntity(Form::class)) {
            $requestData = $event->getContext()->getRequestData();
            $event->getContext()->addRepository('formField', EntityGenerator::getGeneratedEntity(FormField::class));

            foreach ($requestData['fields'] ?? [] as $fieldArray) {
                $field = $event->getContext()->getEntityByIdentifier($fieldArray['id'], 'id', 'formField');

                $field->__set('position', $fieldArray['position']);
                $field->__set('identifier', $fieldArray['identifier']);
                $field->__set('label', $fieldArray['label']);
                $field->__set('type', $fieldArray['type']);
                $field->__set('validationType', $fieldArray['validationType']);
                $field->__set('fieldConfiguration', DataHandler::getJsonEncode($fieldArray['fieldConfiguration']));
                $field->__set('required', $fieldArray['required']);
                $field->__set('useAsName', $fieldArray['useAsName']);
                $field->__set('useAsLastName', $fieldArray['useAsLastName']);
                $field->__set('useAsAddress', $fieldArray['useAsAddress']);

                $event->getContext()->getEntityManager()->persist($field);
                $event->getContext()->getEntityManager()->flush();

                if (!DataHandler::isEmpty($fieldArray['children'] ?? [])) {
                    foreach ($fieldArray['children'] as $child) {
                        $childField = $event->getContext()->getEntityByIdentifier($child['id'], 'id', 'formField');
        
                        $childField->__set('position', $child['position']);
                        $childField->__set('identifier', $child['identifier']);
                        $childField->__set('label', $child['label']);
                        $childField->__set('type', $child['type']);
                        $childField->__set('fieldConfiguration', DataHandler::getJsonEncode($child['fieldConfiguration']));
                        $childField->__set('validationType', $child['validationType']);
                        $childField->__set('required', $child['required']);
                        $childField->__set('useAsName', $child['useAsName']);
                        $childField->__set('useAsLastName', $child['useAsLastName']);
                        $childField->__set('useAsAddress', $child['useAsAddress']);

                        $event->getContext()->getEntityManager()->persist($childField);
                        $event->getContext()->getEntityManager()->flush();
                    }
                }
            }
        }
    }
}