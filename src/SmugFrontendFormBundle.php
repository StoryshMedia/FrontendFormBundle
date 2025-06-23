<?php

namespace Smug\FrontendFormBundle;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Smug\FrontendFormBundle\DependencyInjection\SmugFrontendFormExtension;

class SmugFrontendFormBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SmugFrontendFormExtension();
    }
}
