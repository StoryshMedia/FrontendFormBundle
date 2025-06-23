<?php

namespace Smug\FrontendFormBundle\Entity\Result;

use Smug\Core\Service\Base\Query\QueryMapper;
use Smug\Core\Service\Base\Components\Handler\DataHandler;

class ResultPreparer extends QueryMapper
{
    public function prepare(array $data, array $mapValues): array
    {
        $data['data'] = $data;

        return DataHandler::mergeArray($data, $mapValues);
    }
}
