<?php
namespace Smug\FrontendFormBundle\Event\Data;

use Smug\Core\Context\Context;
use Smug\Core\Entity\Base\BaseModel;
use Symfony\Contracts\EventDispatcher\Event;
 
class FormFieldTypesLoadedEvent extends Event
{
    public const NAME = 'data.form.field.types.loaded';

    protected array $data;
    protected array $config;
    protected Context $context;
 
    public function __construct(
        array $data = [],
        Context $context
    ) {
        $this->data = $data;
        $this->context = $context;
    }

    public function getData(): BaseModel|array
    {
        return $this->data;
    }

    public function setData(BaseModel|array $data): void
    {
        $this->data = $data;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function getContext(): Context
    {
        return $this->context;    
    }
}