<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Service\File\FileResponseBuilderInterface;
use App\Service\File\LocalFileResponseBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FileResponseBuilderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->setAlias(FileResponseBuilderInterface::class, LocalFileResponseBuilder::class);
    }
}
