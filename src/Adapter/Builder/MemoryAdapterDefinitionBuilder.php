<?php

/*
 * This file is part of the flysystem-bundle project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\FlysystemBundle\Adapter\Builder;

use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @internal
 */
class MemoryAdapterDefinitionBuilder extends AbstractAdapterDefinitionBuilder
{
    public function getName(): string
    {
        return 'memory';
    }

    protected function getRequiredPackages(): array
    {
        return [
            InMemoryFilesystemAdapter::class => 'league/flysystem-memory',
        ];
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
    }

    protected function configureDefinition(Definition $definition, array $options)
    {
        $definition->setClass(InMemoryFilesystemAdapter::class);
    }
}
