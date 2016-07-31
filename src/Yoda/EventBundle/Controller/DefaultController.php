<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('EventBundle:Event');

        $event = $repo->findOneBy(array( 'name' => 'Darth\'s surprise birthday party' ));

        $year = date("Y");
        return $this->render('EventBundle:Default:index.html.twig', array('name' => $name,
                                                                          'year' => $year,
                                                                          'event' => $event));

        /**
        $data = [
            'name' => $name,
            'year' => $year,
            'message' => 'mua ha ha ha!!!'
        ];
        $json = json_encode($data);

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
         * **/
    }
}
