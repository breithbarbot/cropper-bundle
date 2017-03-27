<?php
/******************************************************************************
 * Copyright (c) 2017 Cropper. All rights reserved.                           *
 * Author      : Breith Barbot                                                *
 * Updated at  : 12/03/17 16:54                                               *
 * File name   : BreithbarbotCropperExtension.php                             *
 * Description :                                                              *
 ******************************************************************************/

namespace Breithbarbot\CropperBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html Documentation Load Service Configuration
 */
class BreithbarbotCropperExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('breithbarbot_cropper.default_folder', $config['config']['default_folder']);
        $container->setParameter('breithbarbot_cropper.data_class', $config['config']['data_class']);
        $container->setParameter('breithbarbot_cropper.mappings', $config['mappings']);
    }
}