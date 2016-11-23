<?php

/**
 * Register this bundle and the legacy extensions it contains
 */

namespace Bamboo\SwitchUserBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BambooSwitchUserBundle extends Bundle
{
    public function build( ContainerBuilder $container )
    {
        parent::build( $container );

        $extension = $container->getExtension( 'ezpublish' );

        // Only eZ Platform allows us to define policies in Symfony
        if ( method_exists( $extension, 'addPolicyProvider' ) ) {
            $extension->addPolicyProvider( new Security\PolicyProvider() );
        }
    }

    /**
     * Register the legacy extension so that the legacy admin interface can find the
     * policy.
     *
     * This method will be ignored if EzPublishLegacyBundle has not been registered.
     *
     * @return array
     */
    public function getLegacyExtensionsNames()
    {
        return array( 'switchuserbundle' );
    }
}
