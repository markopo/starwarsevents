<?php
/**
 * Created by PhpStorm.
 * User: marko
 * Date: 29/08/2016
 * Time: 07:12
 */

namespace Yoda\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller {


    public function indexAction() {
        return new Response("");
    }

    public function updatedEventsAction() {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('EventBundle:Event')->getRecentlyUpdatedEvents();
        $rows = array();

        foreach($events as $event) {
            $data = array(
               $event->getId(),
               $event->getName(),
               $event->getTime()->format('Y-m-d H:i:s')
            );

            $rows[] = implode(', ', $data);
        }

        $content = implode("\n ", $rows);
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
        return $response;
    }

} 