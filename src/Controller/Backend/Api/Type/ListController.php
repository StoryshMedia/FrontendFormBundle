<?php

namespace Smug\FrontendFormBundle\Controller\Backend\Api\Type;

use Smug\Core\Service\Base\Components\Handler\DataHandler;
use Smug\FrontendBundle\Controller\Frontend\Api\Base\FeBaseController;
use Smug\FrontendFormBundle\Event\Data\FormFieldTypesLoadedEvent;
use Smug\FrontendFormBundle\Event\FrontendFormEvents;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListController extends FeBaseController
{
    #[Route('/be/api/custom/form/field/types', name: 'be_api_form_field_type_list', methods:"GET")]
    public function getFieldTypesAction(
    ): JsonResponse {
        $data = DataHandler::getJsonDecode(
            DataHandler::getFile(__DIR__ . '/../../../../../config/administration/fieldTypes.json')
        );

        $data = $this->dispatchData(
            $data,
            $this->context,
            FormFieldTypesLoadedEvent::class, '', FrontendFormEvents::FRONTEND_FORM_FIELD_TYPES_LOADED
        );

        return $this->prepareReturn($data);
    }
}