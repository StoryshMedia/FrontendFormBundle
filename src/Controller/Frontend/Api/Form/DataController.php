<?php

namespace Smug\FrontendFormBundle\Controller\Frontend\Api\Form;

use Smug\Core\Http\Foundation\Request;
use Smug\Core\Service\Base\Components\Handler\DataHandler;
use Smug\Core\Service\Base\Components\Handler\TimeHandler;
use Smug\Core\Service\Base\Components\Provider\DataProvider\TimeProvider;
use Smug\Core\Service\Base\Service\AddBaseService;
use Smug\FrontendBundle\Controller\Frontend\Api\Base\FeBaseController;
use Smug\FrontendFormBundle\Entity\Result\Result;
use Smug\FrontendFormBundle\Event\Data\FormFieldTypesLoadedEvent;
use Smug\FrontendFormBundle\Event\FrontendFormEvents;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataController extends FeBaseController
{
    #[Route('/be/api/custom/form/field/types', name: 'be_api_form_field_type_list', methods:"GET")]
    public function getFieldTypesAction(
    ): JsonResponse {
        $data = DataHandler::getJsonDecode(
            DataHandler::getFile(__DIR__ . 'config/administration/fieldTypes.json')
        );

        $data = $this->dispatchData(
            $data,
            $this->context,
            FormFieldTypesLoadedEvent::class, '', FrontendFormEvents::FRONTEND_FORM_FIELD_TYPES_LOADED
        );

        return $this->prepareReturn($data);
    }

    #[Route(
        '/fe/api/custom/dynamic/form',
        name: 'fe_dynamic_form_add',
        methods: ['POST'],
    )]
    public function addAction(Request $request, AddBaseService $service): JsonResponse
    {
        $this->context->buildFromRequest(
            $request,
            Result::class
        );

        if (DataHandler::isEmpty($this->context->getRequestData())) {
            return $this->prepareReturn([
                'success' => false,
                'message' => 'Not Data permitted'
            ]);
        }

        if ($this->context->getRequestData()['fax'] ?? '' !== '') {
            return $this->prepareReturn([
                'success' => false,
                'message' => 'Bot detected'
            ]);
        }

        $this->context->updateData('type', (DataHandler::doesKeyExists('HTTP_REFERER', $_SERVER)) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REMOTE_ADDR']);
        $this->context->updateData('date', TimeHandler::getFormatDate(TimeHandler::getNewDateObject(), TimeProvider::DATE_TIME_OUTPUT_FORMAT));

        $add = $service->add($this->context);

        if ($add['success'] === true) {
           
        }

        return $this->prepareReturn($add);
    }
}