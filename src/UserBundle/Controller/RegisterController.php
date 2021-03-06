<?php
/**
 * Created by PhpStorm.
 * User: marko
 * Date: 09/08/2016
 * Time: 20:36
 */

namespace UserBundle\Controller;

use Yoda\EventBundle\Controller\Controller as CustomController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\RegisterFormType;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterController extends CustomController {

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request){

        $defaultUser = new User();
        $defaultUser->setUsername('John Doe');

        $form = $this->createForm(new RegisterFormType(false), $defaultUser, array('constraints' => array(
            new Assert\Callback(array('validateUserName'))
        )));

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

            $this->addFlash('success', 'Welcome to the Death Star! Have a magical day!');

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