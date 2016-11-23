<?php

namespace Bamboo\SwitchUserBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\API\Repository\Values\User\User as ApiUser;
use eZ\Publish\Core\MVC\Symfony\Security\Authorization\Attribute as AuthorizationAttribute;
use eZ\Publish\Core\MVC\Symfony\Security\User;

class SwitchUserController extends Controller
{
    private $deniedGroupIds;
    private $allowedGroupIds;

    private function initialise()
    {
        $this->deniedGroupIds = $this->getParameter( 'bamboo_switch_user.groups.deny' );
        $this->allowedGroupIds = $this->getParameter( 'bamboo_switch_user.groups.allow' );
    }

    /**
     * Switch to the user with the specified ID
     *
     * @param int $id
     * @return Response
     */
    public function setByIdAction( $id )
    {
        $this->denyAccessUnlessGranted( new AuthorizationAttribute( 'switchuser', 'manage' ) );

        $apiUser = $this->getRepository()->getUserService()->loadUser( $id );
        return $this->setByApiUser( $apiUser );
    }

    /**
     * Switch to the user with the specified username
     *
     * @param type $username
     * @return Response
     */
    public function setByLoginAction( $username )
    {
        $this->denyAccessUnlessGranted( new AuthorizationAttribute( 'switchuser', 'manage' ) );

        $apiUser = $this->getRepository()->getUserService()->loadUserByLogin( $username );
        return $this->setByApiUser( $apiUser );
    }

    /**
     * Change the current user to the specified API user and redirect to the home page
     *
     * @todo: Don't assume that the user belongs to less than 25 user groups
     *
     * @param type $username
     * @return Response
     * @throws \RuntimeException
     */
    public function setByApiUser( ApiUser $apiUser )
    {
        $this->initialise();

        // Fetch the first 25 user groups for this user
        $userGroups = $this->getRepository()->getUserService()->loadUserGroupsOfUser( $apiUser );

        foreach ( $userGroups as $group ) {
            if ( !$this->canSwitchToGroup( $group->id ) ) {
                throw new \RuntimeException( 'Settings forbid switching to a user in the "'
                                             . $group->contentInfo->name
                                             . '" user group [ID: ' . $group->id . ']' );
            }
        }

        $this->getRepository()->setCurrentUser( $apiUser );
        $token = $this->get( 'security.token_storage' )->getToken();
        $token->setUser( new User( $apiUser ) );
        return $this->redirect( '/' );
    }

    /**
     * Test whether it is permitted to switch to a user belonging to the specified user group
     * The 'allow' setting takes precendence over the 'deny' setting.
     *
     * @param int $userGroupId
     * @return boolean
     */
    private function canSwitchToGroup( $userGroupId )
    {
        if ( $this->allowedGroupIds ) {
            return in_array( $userGroupId, $this->allowedGroupIds );
        } else {
            return !in_array( $userGroupId, $this->deniedGroupIds );
        }
    }
}
