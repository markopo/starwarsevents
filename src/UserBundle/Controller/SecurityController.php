<?php

namespace UserBundle\Controller;

use AppBundle\Utils\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Translations\Translations;

class SecurityController extends Controller {

    /**
     * @Route("/login", name="login_form")
     */
    public function loginAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');

        $lastUsername = $helper->getLastUsername();
        $error = $helper->getLastAuthenticationError();
        $messageKey = $error != null ? $error->getMessageKey() : null;
        $errormessage = "";
        if($messageKey != null) {
            $trans = new Translations();
            $errormessage = $trans->get($messageKey);
        }

        return $this->render(':security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'name'          => Helper::GetName(),
            'errormessage' => $errormessage
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction(){

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){

    }

} 