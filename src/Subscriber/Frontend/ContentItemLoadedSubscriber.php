<?php

namespace Smug\FrontendFormBundle\Subscriber\Frontend;

use Smug\Core\Context\Context;
use Smug\Core\DataAbstractionLayer\EntityGenerator;
use Smug\Core\Events\Frontend\Site\ContentItemLoadedEvent;
use Smug\Core\Service\Base\Components\Handler\DataHandler;
use Smug\Core\Service\Base\Components\Serializer\EntitySerializer;
use Smug\FrontendBundle\Event\FrontendEvents;
use Smug\FrontendBundle\Subscriber\Frontend\ContentItemRenderingSubscriber;
use Smug\FrontendFormBundle\Entity\Form\Form;

class ContentItemLoadedSubscriber extends ContentItemRenderingSubscriber
{
    protected array $identifiers;

    protected Context $context;

    public function __construct(Context $context, protected EntitySerializer $serializer)
    {
        $this->context = $context;
        $this->identifiers = [
            'SmugDynamicFrontendForm'
        ];
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FrontendEvents::FRONTEND_CONTENT_ITEM_LOADED => 'onContentItemLoaded'
        ];
    }

    public function onContentItemLoaded(ContentItemLoadedEvent $event): void
    {
        $data = $event->getData();

        if (self::doProcess($data, $this->identifiers[0])) {
            $form = $this->context->getEntityManager()->getRepository(EntityGenerator::getGeneratedEntity(Form::class))->findOneBy(['id' => $data['variables']['pluginSettings']['form'] ?? '']);
            
            if (!DataHandler::isEmpty($form)) {
                $formArray = $this->serializer->serialize($form);
                $formArray['fields'] = DataHandler::sortItemsByField($formArray['fields'], 'position');
                $data['variables']['pluginSettings']['form'] = $formArray;
                $data['variables']['pluginSettingsJson'] = DataHandler::getJsonEncode($data['variables']['pluginSettings']);
            }
        }

        $event->setData($data);
    }
}