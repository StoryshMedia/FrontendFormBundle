<?php

namespace Smug\FrontendFormBundle\Entity\FormField;

use Smug\Core\Service\Base\Components\Handler\DataHandler;
use Smug\Core\Service\Base\Query\QueryMapper;

class FormFieldPreparer extends QueryMapper
{
    public function prepare(array $item, array $mapValues): array
    {
        return DataHandler::mergeArray($item, $mapValues);
    }
}
