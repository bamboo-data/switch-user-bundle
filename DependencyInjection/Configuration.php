<?php

namespace Bamboo\SwitchUserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * By default allow switching to any user group apart from Administrator
     * Users (12) or Anonymous Users (42)
     */
    var $forbiddenGroups = [ 12, 42 ];

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root( 'bamboo_switch_user' );

        $rootNode
            ->children()
                ->arrayNode( 'groups' )
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode( 'deny' )
                            ->prototype( 'integer' )->end()
                            ->defaultValue( $this->forbiddenGroups )
                        ->end()
                        ->arrayNode( 'allow' )
                            ->prototype( 'integer' )->end()
                            ->defaultValue( [] )
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
