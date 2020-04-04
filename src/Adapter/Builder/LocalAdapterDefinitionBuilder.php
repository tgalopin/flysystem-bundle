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

use League\Flysystem\Local\LocalFilesystemAdapter;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @internal
 */
class LocalAdapterDefinitionBuilder extends AbstractAdapterDefinitionBuilder
{
    public function getName(): string
    {
        return 'local';
    }

    protected function getRequiredPackages(): array
    {
        return [];
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('directory');
        $resolver->setAllowedTypes('directory', 'string');

        $resolver->setDefault('lock', 0);
        $resolver->setAllowedTypes('lock', 'scalar');

        $resolver->setDefault('skip_links', false);
        $resolver->setAllowedTypes('skip_links', 'scalar');

        $resolver->setDefault('permissions', function (OptionsResolver $subResolver) {
            $subResolver->setDefault('file', function (OptionsResolver $permsResolver) {
                $permsResolver->setDefault('public', 0644);
                $permsResolver->setAllowedTypes('public', 'scalar');

                $permsResolver->setDefault('private', 0600);
                $permsResolver->setAllowedTypes('private', 'scalar');
            });

            $subResolver->setDefault('dir', function (OptionsResolver $permsResolver) {
                $permsResolver->setDefault('public', 0755);
                $permsResolver->setAllowedTypes('public', 'scalar');

                $permsResolver->setDefault('private', 0700);
                $permsResolver->setAllowedTypes('private', 'scalar');
            });
        });
    }

    protected function configureDefinition(Definition $definition, array $options)
    {
        $definition->setClass(LocalFilesystemAdapter::class);
        $definition->setArgument(0, $options['directory']);
        $definition->setArgument(1, $options['lock']);
        $definition->setArgument(2, $options['skip_links'] ? LocalFilesystemAdapter::SKIP_LINKS : LocalFilesystemAdapter::DISALLOW_LINKS);
        $definition->setArgument(3, $options['permissions']);
    }
}
