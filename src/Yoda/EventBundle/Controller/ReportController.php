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
use Yoda\EventBundle\Reporting\EventReportManager;


class ReportController extends Controller {


    public function indexAction() {
        return new Response("");
    }

    public function updatedEventsAction() {

        $em = $this->getDoctrine()->getManager();
        $eventReportManager = new EventReportManager($em);
        $content = $eventReportManager->getRecentlyUpdatedReport();

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
        return $response;
    }

} 