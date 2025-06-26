<?php

namespace Smug\FrontendFormBundle\Controller\Backend\Api\Template;

use Smug\FrontendBundle\Controller\Frontend\Api\Base\FeBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Smug\FrontendFormBundle\Event\Data\TemplateListLoadedEvent;
use Smug\FrontendFormBundle\Event\TemplateEvents;
use Symfony\Component\HttpFoundation\JsonResponse;

class TemplateController extends FeBaseController
{
    #[Route('/be/api/custom/email/template/list', name: 'be_get_email_template_list', methods:"GET")]
    public function getTemplateList(Request $request): JsonResponse
    {
        $this->context->buildFromRequest(
            $request,
            ''
        );

        $data = $this->dispatchData(
            [
                [
                    'title' => 'STANDARD',
                    'value' => '@SmugFrontendForm/email/confirmation/html/index.html.twig'
                ]
            ],
            $this->context,
            TemplateListLoadedEvent::class,
            '',
            TemplateEvents::FRONTEND_EMAIL_TEMPLATE_LIST_LOADED
        );

        return $this->prepareReturn($data);
    }
}