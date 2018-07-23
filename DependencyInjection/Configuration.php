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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('breithbarbot_cropper');

        $rootNode
            ->children()
                ->arrayNode('mappings')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('routes')
                                ->isRequired()
                                ->children()
                                    ->scalarNode('add_path')->isRequired()->cannotBeEmpty()->end()
                                    ->scalarNode('delete_path')->end()
                                ->end()
                            ->end()
                            ->scalarNode('width')->defaultValue(1280)->end()
                            ->scalarNode('height')->defaultValue(720)->end()
                            ->scalarNode('ratio')->defaultValue('16/9')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
