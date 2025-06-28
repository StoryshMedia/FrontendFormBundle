<?php

namespace Smug\FrontendFormBundle\Entity\FormField;

use Smug\Core\Entity\Base\BaseModel;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Smug\Core\Entity\Base\Attribute\BackendField;
use Smug\Core\Entity\Base\Attribute\DefaultValue;
use Smug\FrontendFormBundle\Entity\Form\Form;
use Symfony\Component\Serializer\Attribute\Groups;

#[Entity]
#[Table('frontend_form_field')]
class FormField extends BaseModel
{
    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'TYPE'
    ])]
    #[Groups(['public'])]
    protected string $type;
    
    #[Column(type: 'boolean')]
    #[DefaultValue(false)]
    #[BackendField(config: [
        'type' => 'Checkbox',
        'placeholder' => 'NO_INDEX',
        'config' => [
            'trueLabel' => 'YES',
            'falseLabel' => 'NO'
        ]
    ])]
    #[Groups(['public'])]
    protected string $useAsName;
    
    #[Column(type: 'boolean')]
    #[DefaultValue(false)]
    #[BackendField(config: [
        'type' => 'Checkbox',
        'placeholder' => 'NO_INDEX',
        'config' => [
            'trueLabel' => 'YES',
            'falseLabel' => 'NO'
        ]
    ])]
    #[Groups(['public'])]
    protected string $useAsLastName;
    
    #[Column(type: 'boolean')]
    #[DefaultValue(false)]
    #[BackendField(config: [
        'type' => 'Checkbox',
        'placeholder' => 'NO_INDEX',
        'config' => [
            'trueLabel' => 'YES',
            'falseLabel' => 'NO'
        ]
    ])]
    #[Groups(['public'])]
    protected string $useAsAddress;

    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'IDENTIFIER'
    ])]
    #[Groups(['public'])]
    protected string $identifier;

    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'LABEL'
    ])]
    #[Groups(['public'])]
    protected string $label;

    #[ManyToOne(targetEntity: Form::class, inversedBy: 'fields')]
    #[JoinColumn(name: 'form_id', referencedColumnName: 'id', onDelete: 'cascade', nullable: true)]
    #[Groups(['public'])]
    protected Form $form;

    #[Column(type: 'integer')]
    #[BackendField(config: [
        'type' => 'Number',
        'placeholder' => 'POSITION'
    ])]
    #[Groups(['public'])]
    protected int $position;

    #[Column(type: 'string')]
    #[Groups(['public'])]
    protected string $parentId = '';

    #[Column(type: 'boolean')]
    #[DefaultValue(false)]
    #[BackendField(config: [
        'type' => 'Checkbox',
        'placeholder' => 'NO_INDEX',
        'config' => [
            'trueLabel' => 'YES',
            'falseLabel' => 'NO'
        ]
    ])]
    #[Groups(['public'])]
    protected $required;

    #[Column(type: 'string')]
    #[DefaultValue('')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'VALIDATION_TYPE'
    ])]
    #[Groups(['public'])]
    protected string $validationType;

    #[Column(type: 'jsonField')]
    #[DefaultValue([])]
    #[Groups(['public'])]
    protected string|array $fieldConfiguration;
}
