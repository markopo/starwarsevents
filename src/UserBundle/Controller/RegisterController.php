<?php
/**
 * Created by PhpStorm.
 * User: marko
 * Date: 09/08/2016
 * Time: 20:36
 */

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RegisterController extends Controller {

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(){
        $form = $this->createFormBuilder()
                ->add('username', 'text')
                ->add('email', 'text')
                ->add('password', 'password')
                ->getForm();

        return $this->render(':register:register.html.twig', array('form' => $form->createView()));
    }

} 