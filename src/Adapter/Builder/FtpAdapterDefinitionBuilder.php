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

use League\Flysystem\FTP\FtpAdapter;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @internal
 */
class FtpAdapterDefinitionBuilder extends AbstractAdapterDefinitionBuilder
{
    public function getName(): string
    {
        return 'ftp';
    }

    protected function getRequiredPackages(): array
    {
        return [
            FtpAdapter::class => 'league/flysystem-ftp',
        ];
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('host');
        $resolver->setAllowedTypes('host', 'string');

        $resolver->setRequired('username');
        $resolver->setAllowedTypes('username', 'string');

        $resolver->setRequired('password');
        $resolver->setAllowedTypes('password', 'string');

        $resolver->setDefault('port', 21);
        $resolver->setAllowedTypes('port', 'scalar');

        $resolver->setDefault('root', '');
        $resolver->setAllowedTypes('root', 'string');

        $resolver->setDefault('passive', true);
        $resolver->setAllowedTypes('passive', 'scalar');

        $resolver->setDefault('ssl', false);
        $resolver->setAllowedTypes('ssl', 'scalar');

        $resolver->setDefault('timeout', 90);
        $resolver->setAllowedTypes('timeout', 'scalar');

        $resolver->setDefault('ignore_passive_address', null);
        $resolver->setAllowedTypes('ignore_passive_address', ['null', 'bool']);

        $resolver->setDefault('utf8', false);
        $resolver->setAllowedTypes('utf8', 'bool');
    }

    protected function configureDefinition(Definition $definition, array $options)
    {
        $options['ignorePassiveAddress'] = $options['ignore_passive_address'];
        unset($options['ignore_passive_address']);

        $definition->setClass(FtpAdapter::class);
        $definition->setArgument(0, $options);
    }
}
