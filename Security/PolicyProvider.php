<?php

namespace Bamboo\SwitchUserBundle\Security;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ConfigBuilderInterface;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;

/**
 * Define the switchuser/manage policy
 *
 * @author Andy Caiger <acaiger@bamboo-data.co.uk>
 */
class PolicyProvider implements PolicyProviderInterface
{
    public function addPolicies( ConfigBuilderInterface $configBuilder )
    {
        $configBuilder->addConfig( [
             'switchuser' => [
                 'manage' => null
             ],
         ]);
    }
}
