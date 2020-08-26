<?php

/*
 * This file is part of the flysystem-bundle project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\FlysystemBundle\DependencyInjection;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use League\Flysystem\PluginInterface;
use League\FlysystemBundle\Adapter\AdapterDefinitionFactory;
use League\FlysystemBundle\Lazy\LazyFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class FlysystemExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container
            ->registerForAutoconfiguration(PluginInterface::class)
            ->addTag('flysystem.plugin')
        ;

        $container
            ->setDefinition('flysystem.adapter.lazy.factory', new Definition(LazyFactory::class))
            ->setPublic(false)
        ;

        $this->createStoragesDefinitions($config, $container);
    }

    private function createStoragesDefinitions(array $config, ContainerBuilder $container)
    {
        $definitionFactory = new AdapterDefinitionFactory();

        $mountManager = $container->setDefinition('flysystem.mount_manager', $this->createMountManagerDefinition());
        $container->setAlias(MountManager::class, 'flysystem.mount_manager');

        foreach ($config['storages'] as $storageName => $storageConfig) {
            // If the storage is a lazy one, it's resolved at runtime
            if ('lazy' === $storageConfig['adapter']) {
                $container->setDefinition($storageName, $this->createLazyStorageDefinition($storageName, $storageConfig['options']));

                // Register named autowiring alias
                $container->registerAliasForArgument($storageName, FilesystemInterface::class, $storageName)->setPublic(false);

                continue;
            }

            // Create adapter definition
            if ($adapter = $definitionFactory->createDefinition($storageConfig['adapter'], $storageConfig['options'])) {
                // Native adapter
                $container->setDefinition('flysystem.adapter.'.$storageName, $adapter)->setPublic(false);
            } else {
                // Custom adapter
                $container->setAlias('flysystem.adapter.'.$storageName, $storageConfig['adapter'])->setPublic(false);
            }

            // Create storage definition
            $container->setDefinition(
                $storageName,
                $this->createStorageDefinition($storageName, new Reference('flysystem.adapter.'.$storageName), $storageConfig)
            );

            // Register named autowiring alias
            $container->registerAliasForArgument($storageName, FilesystemInterface::class, $storageName)->setPublic(false);

            // Register with the mount manager if a mount prefix was given
            if (null !== $storageConfig['mount_prefix']) {
                $mountManager->addMethodCall('mountFilesystem', [$storageConfig['mount_prefix'], new Reference($storageName)]);
            }
        }
    }

    private function createLazyStorageDefinition(string $storageName, array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('source');
        $resolver->setAllowedTypes('source', 'string');

        $definition = new Definition(FilesystemInterface::class);
        $definition->setPublic(false);
        $definition->setFactory([new Reference('flysystem.adapter.lazy.factory'), 'createStorage']);
        $definition->setArgument(0, $resolver->resolve($options)['source']);
        $definition->setArgument(1, $storageName);
        $definition->addTag('flysystem.storage', ['storage' => $storageName]);

        return $definition;
    }

    private function createStorageDefinition(string $storageName, Reference $adapter, array $config)
    {
        $definition = new Definition(Filesystem::class);
        $definition->setPublic(false);
        $definition->setArgument(0, $adapter);
        $definition->setArgument(1, [
            'visibility' => $config['visibility'],
            'case_sensitive' => $config['case_sensitive'],
            'disable_asserts' => $config['disable_asserts'],
        ]);
        $definition->addTag('flysystem.storage', ['storage' => $storageName]);

        return $definition;
    }

    private function createMountManagerDefinition()
    {
        $definition = new Definition(MountManager::class);
        $definition->setPublic(false);

        return $definition;
    }
}
