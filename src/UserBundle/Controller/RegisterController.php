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
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class RegisterController extends Controller {

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request){

        $defaultUser = new User();
        $defaultUser->setUsername('John Doe');

        $form = $this->createFormBuilder($defaultUser, array('data_class' => 'UserBundle\Entity\User'))
                ->add('username', 'text')
                ->add('email', 'text')
                ->add('plainPassword', 'repeated', array('type' => 'password'))
                ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // var_dump($form->getData());die;

            $submittedUser = $form->getData();

            $user = new User();
            $user->setUsername($submittedUser->getUsername());
            $user->setEmail($submittedUser->getEmail());
            $user->setPassword($this->encodePassword($user, $submittedUser->getPlainPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $url = $this->generateUrl('event_index');
            return $this->redirect($url);
        }


        return $this->render(':register:register.html.twig', array('form' => $form->createView()));
    }

    private function encodePassword(User $user, $plainPassword) {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

} 