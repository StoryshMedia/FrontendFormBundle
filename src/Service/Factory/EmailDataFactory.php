<?php

namespace Smug\FrontendFormBundle\Service\Factory;

use Exception;
use Smug\Core\Context\Context;
use Smug\Core\DataAbstractionLayer\EntityGenerator;
use Smug\Core\Service\Base\Components\Handler\DataHandler;
use Smug\Core\Service\Email\EmailData;
use Smug\FrontendFormBundle\Entity\Form\Form;
use Smug\FrontendFormBundle\Entity\FormField\FormField;

class EmailDataFactory
{
    public static function getEmailData(Context $context, $form): EmailData
    {
        if (!DataHandler::isInstanceOf($form, EntityGenerator::getGeneratedEntity(Form::class))) {
            throw new Exception('No valid form given');
        }
        $context->addRepository('field', EntityGenerator::getGeneratedEntity(FormField::class));

        $emailData = new EmailData();

        $emailData->__set('template', $form->__get('emailTemplate'));
        $emailData->__set('subject', $form->__get('subject'));
        $emailData->__set('sender', [
            'name' => $form->__get('senderName'),
            'email' => $form->__get('senderEmail')
        ]);
        $emailData->__set(
            'recipients',
            self::getRecipientData(
                $context,
                $context->getRequestData(),
                $form->__get('fields')
            )
        );
        $emailData->__add(
            'recipients',
            [
                'name' => $form->__get('senderName'),
                'email' => $form->__get('senderEmail')
            ]
        );
        $emailData->__set(
            'data',
            self::getTemplateData(
                $context,
                $context->getRequestData(),
                $form->__get('fields')
            )
        );
            
        return $emailData;
    }

    private static function getTemplateData(Context $context, array $data, $fields): array
    {
        $templateData = [];
        $name = '';
        $lastName = '';

        foreach ($fields as $field) {
            if ($field->__get('type') === 'row') {
                $childFields = $context->getEntitiesByIdentifier($field->__get('id', 'parentId', 'field'));

                foreach ($childFields as $childField) {
                    $templateData[$childField->__get('label')] = (DataHandler::doesKeyExists($childField->__get('identifier'), $data)) ? $data[$childField->__get('identifier')] : '';
                    
                    if ($childField->__get('useAsName')) {
                        $name = (DataHandler::doesKeyExists($childField->__get('identifier'), $data)) ? $data[$childField->__get('identifier')] : '';
                    }
                    if ($childField->__get('useAsLastName')) {
                        $lastName = (DataHandler::doesKeyExists($childField->__get('identifier'), $data)) ? $data[$childField->__get('identifier')] : '';
                    }
                }

                continue;
            }

            if ($field->__get('useAsName')) {
                $name = (DataHandler::doesKeyExists($field->__get('identifier'), $data)) ? $data[$field->__get('identifier')] : '';
            }
            if ($field->__get('useAsLastName')) {
                $lastName = (DataHandler::doesKeyExists($field->__get('identifier'), $data)) ? $data[$field->__get('identifier')] : '';
            }

            $templateData[$field->__get('label')] = (DataHandler::doesKeyExists($field->__get('identifier'), $data)) ? $data[$field->__get('identifier')] : '';
        }

        $templateData['salutation'] = $name . ' ' . $lastName;

        return $templateData;
    }

    private static function getRecipientData(Context $context, array $data, $fields): array
    {
        $recipientData = [
            'name' => '',
            'email' => ''
        ];

        $name = '';
        $lastName = '';

        foreach ($fields as $field) {
            if ($field->__get('type') === 'row') {
                $childFields = $context->getEntitiesByIdentifier($field->__get('id', 'parentId', 'field'));

                foreach ($childFields as $childField) {
                    if ($childField->__get('useAsAddress')) {
                        $recipientData['email'] = (DataHandler::doesKeyExists($childField->__get('identifier'), $data)) ? $data[$childField->__get('identifier')] : '';
                    }
                    if ($childField->__get('useAsName')) {
                        $name = (DataHandler::doesKeyExists($childField->__get('identifier'), $data)) ? $data[$childField->__get('identifier')] : '';
                    }
                    if ($childField->__get('useAsLastName')) {
                        $lastName = (DataHandler::doesKeyExists($childField->__get('identifier'), $data)) ? $data[$childField->__get('identifier')] : '';
                    }
                }

                continue;
            }

            if ($field->__get('useAsAddress')) {
                $recipientData['email'] = (DataHandler::doesKeyExists($field->__get('identifier'), $data)) ? $data[$field->__get('identifier')] : '';
            }
            if ($field->__get('useAsName')) {
                $name = (DataHandler::doesKeyExists($field->__get('identifier'), $data)) ? $data[$field->__get('identifier')] : '';
            }
            if ($field->__get('useAsLastName')) {
                $lastName = (DataHandler::doesKeyExists($field->__get('identifier'), $data)) ? $data[$field->__get('identifier')] : '';
            }
        }

        $recipientData['name'] = $name . ' ' . $lastName;

        return [$recipientData];
    }
}