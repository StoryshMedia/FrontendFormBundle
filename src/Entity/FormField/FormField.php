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
    protected string $useAsAddress;

    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'IDENTIFIER'
    ])]
    protected string $identifier;

    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'LABEL'
    ])]
    protected string $label;

    #[ManyToOne(targetEntity: Form::class, inversedBy: 'fields')]
    #[JoinColumn(name: 'form_id', referencedColumnName: 'id', onDelete: 'cascade', nullable: true)]
    #[Groups(['minimal'])]
    protected Form $form;

    #[Column(type: 'integer')]
    #[BackendField(config: [
        'type' => 'Number',
        'placeholder' => 'POSITION'
    ])]
    protected int $position;

    #[Column(type: 'string')]
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
    protected $required;

    #[Column(type: 'string')]
    #[DefaultValue('')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'VALIDATION_TYPE'
    ])]
    protected string $validationType;

    #[Column(type: 'jsonField')]
    #[DefaultValue([])]
    protected string|array $fieldConfiguration;
}
