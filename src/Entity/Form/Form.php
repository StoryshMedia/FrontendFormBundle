<?php

namespace Smug\FrontendFormBundle\Entity\Form;

use Smug\Core\Entity\Base\BaseModel;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Smug\Core\Entity\Base\Attribute\BackendField;
use Smug\Core\Entity\Base\Attribute\DefaultValue;
use Smug\FrontendFormBundle\Entity\FormField\FormField;
use Smug\FrontendFormBundle\Entity\Result\Result;

#[Entity]
#[Table('frontend_form')]
class Form extends BaseModel
{
    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'TITLE'
    ])]
    protected string $title;

    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Email',
        'placeholder' => 'SENDER_EMAIL'
    ])]
    protected string $senderEmail;

    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'SENDER_NAME'
    ])]
    protected string $senderName;

    #[Column(type: 'string')]
    #[BackendField(config: [
        'type' => 'Text',
        'placeholder' => 'SUBJECT_FOR_CONFIRMATION'
    ])]
    protected string $subject;

    #[Column(type: 'string')]
    #[DefaultValue('@SmugFrontendForm/email/confirmation/html/index.html.twig')]
    #[BackendField(config: [
        'type' => 'Selectbox',
        'placeholder' => 'TEMPLATE',
        'config' => [
            'getCall' => '/be/api/custom/email/template/list'
        ]
    ])]
    protected string $emailTemplate;

    #[OneToMany(targetEntity: FormField::class, mappedBy: 'form')]
    #[Groups(['list', 'nested'])]
    #[BackendField(config: [
        'type' => 'FormFields',
        'placeholder' => 'FIELDS',
        'config' => [
        ]
    ])]
    protected $fields;


    #[OneToMany(targetEntity: Result::class, mappedBy: 'form')]
    #[Groups(['list'])]
    #[BackendField(config: [
        'type' => 'FormResults',
        'placeholder' => 'RESULTS',
        'config' => [
        ]
    ])]
    protected $results;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->results = new ArrayCollection();
    }
}
