<?php

namespace FourLabs\HostsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('four_labs_hosts');

        $rootNode
            ->children()
                ->scalarNode('test_ip')
                    ->defaultNull()
                ->end()
                ->booleanNode('assert_country')
                    ->defaultTrue()
                ->end()
                ->scalarNode('default_domain')
                    ->isRequired()
                ->end()
                ->arrayNode('domains')
                    ->useAttributeAsKey('domains')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('locale')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('currency')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('countries')
                                ->isRequired()
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->scalarNode('mailer')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
