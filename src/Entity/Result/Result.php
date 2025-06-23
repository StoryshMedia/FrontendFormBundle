<?php

namespace Smug\FrontendFormBundle\Entity\Result;

use Smug\Core\Entity\Base\BaseModel;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Column;
use Smug\Core\Entity\Base\Attribute\DefaultValue;
use Smug\FrontendFormBundle\Entity\Form\Form;
use Symfony\Component\Serializer\Attribute\Groups;

#[Entity]
#[Table('frontend_form_result')]
class Result extends BaseModel
{
    #[Column(type: 'jsonField')]
    #[DefaultValue([])]
    protected string|array $data;

    #[ManyToOne(targetEntity: Form::class, inversedBy: 'fields')]
    #[JoinColumn(name: 'form_id', referencedColumnName: 'id', onDelete: 'cascade', nullable: true)]
    #[Groups(['minimal', 'backend'])]
    protected Form $form;
}
