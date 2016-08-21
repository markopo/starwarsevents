<?php
/**
 * Created by PhpStorm.
 * User: marko
 * Date: 21/08/2016
 * Time: 09:27
 */

namespace Yoda\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Yoda\EventBundle\Entity\Event;

class Controller extends BaseController {

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    public function getSecurityContext() {
        return $this->container->get('security.context');
    }

    /**
     * @throws AuthenticationException
     */
    public function enforceUserSecurity() {
        $securityContext = $this->getSecurityContext();
        if(!$securityContext->isGranted('ROLE_ADMIN')){
            throw new AuthenticationException("Need ROLE ADMIN!");
        }
    }

    /**
     * @param Event $event
     */
    public function enforceOwnerSecurity(Event $event){
        $user = $this->getUser();

        if($user != $event->getOwner()){
            throw new AccessDeniedException('You do not own this!');
        }

    }

} 