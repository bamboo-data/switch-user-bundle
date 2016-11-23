<?php

namespace Bamboo\SwitchUserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BambooSwitchUserExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load( array $configs, ContainerBuilder $container )
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration( $configuration, $configs );

        $container->setParameter( 'bamboo_switch_user.groups.deny', $config[ 'groups' ][ 'deny' ] );
        $container->setParameter( 'bamboo_switch_user.groups.allow', $config[ 'groups' ][ 'allow' ] );
    }
}
