<?php

/*
 * This file is part of the Cropper package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Breithbarbot\CropperBundle\DependencyInjection;

use RuntimeException;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @see https://symfony.com/doc/current/configuration/using_parameters_in_dic.html
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('breithbarbot_cropper');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('mappings')
                    ->useAttributeAsKey('id')
                        ->prototype('array')
                            ->children()
                                ->arrayNode('routes')
                                    ->isRequired()
                                    ->children()
                                        ->scalarNode('path_add')->isRequired()->cannotBeEmpty()->end()
                                        ->scalarNode('path_delete')->end()
                                    ->end()
                                ->end()
                                ->scalarNode('width')->defaultValue(1280)->end()
                                ->scalarNode('height')->defaultValue(720)->end()
                                ->scalarNode('ratio')->defaultValue('16/9')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
