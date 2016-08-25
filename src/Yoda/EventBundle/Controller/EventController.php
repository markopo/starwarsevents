<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yoda\EventBundle\Controller\Controller as CustomController;
use Yoda\EventBundle\Entity\Event;
use Yoda\EventBundle\Form\EventType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Event controller.
 *
 */
class EventController extends CustomController
{
    /**
     * Lists all Event entities.
     *
     */
    public function indexAction()
    {
        return $this->render('event/index.html.twig');
    }

    public function _upcomingEventsAction() {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('EventBundle:Event')->getUpcomingEvents();
        return $this->render(':event:_upcomingEvents.html.twig', array('events' => $events));
    }


    /**
     * Creates a new Event entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->enforceUserSecurity();
        $event = new Event();
        $form = $this->createForm('Yoda\EventBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->enforceOwnerSecurity($event);

            $user = $this->getUser();
            $event->setOwner($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
     */
    public function showAction(Event $event)
    {
        $this->enforceUserSecurity();
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     */
    public function editAction(Request $request, Event $event)
    {
        $this->enforceUserSecurity();
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('Yoda\EventBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->enforceOwnerSecurity($event);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Event entity.
     *
     */
    public function deleteAction(Request $request, Event $event)
    {
        $this->enforceUserSecurity();
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->enforceOwnerSecurity($event);

            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }


    public function attendAction($id, $format){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->find($id);

        if(!$event) {
            throw $this->createNotFoundException('Unable to find Event entity!');
        }

        $thisUser = $this->getUser();

        if(!$event->hasAttendee($thisUser)) {
            $event->getAttendees()->add($thisUser);
            $em->persist($event);
            $em->flush();
        }

        return $this->createAttendingResponse($event, $format);
    }

    public function unattendAction($id, $format) {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->find($id);

        if(!$event) {
            throw $this->createNotFoundException('Unable to find Event entity!');
        }

        $thisUser = $this->getUser();

        if($event->hasAttendee($thisUser)) {
            $event->getAttendees()->removeElement($thisUser);
            $em->persist($event);
            $em->flush();
        }

        return $this->createAttendingResponse($event, $format);
    }

    private function createAttendingResponse(Event $event, $format) {

        if($format == 'json') {
            $data = [ 'attending' => $event->hasAttendee($this->getUser()) ];
            $response = new JsonResponse($data);
            return $response;
        }

        $url = $this->generateUrl('event_show', array('slug' => $event->getSlug()));
        return $this->redirect($url);
    }

    /**
     * Creates a form to delete a Event entity.
     *
     * @param Event $event The Event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }




}
