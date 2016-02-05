<?php

namespace SpecShaper\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SpecShaper\CalendarBundle\Model\CalendarEventInterface;
use SpecShaper\CalendarBundle\Form\CalendarEventType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use SpecShaper\CalendarBundle\Doctrine\CalendarEventManager;
use SpecShaper\CalendarBundle\Event\CalendarEvents;
use SpecShaper\CalendarBundle\Event\CalendarLoadEvents;
use SpecShaper\CalendarBundle\Event\CalendarEditEvent;
use SpecShaper\CalendarBundle\Event\CalendarGetAddressesEvent;


/**
 * @Route("/calendar")
 */
class CalendarController extends Controller {

    /**
     * Dispatch a CalendarEvent and return a JSON Response of any events returned.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @todo remove GET
     * @Route("/loader", name="calendar_loader")
     * @Method({"GET","POST"})
     */
    public function loadCalendarAction(Request $request) {
        $viewStartDatetime = new \DateTime();
        $viewStartDatetime->setTimestamp(strtotime($request->get('start')));

        $viewEndDatetime = new \DateTime();
        $viewEndDatetime->setTimestamp(strtotime($request->get('end')));

        $loadEvent = new CalendarLoadEvents($viewStartDatetime, $viewEndDatetime, $request);

        $loadedEvents = $this->getDispatcher()
                ->dispatch(CalendarEvents::CALENDAR_LOAD_EVENTS, $loadEvent)
                ->getEvents();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $return_events = array();

        foreach ($loadedEvents as $calendarEvent) {
            $return_events[] = $calendarEvent->toArray();
        }

        $response->setContent(json_encode($return_events));

        return $response;
    }

    /**
     * Add a new calendar event.
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/addevent", name="event_new")
     * @Method({"GET","POST"})
     */
    public function addEventAction(Request $request) {

        $eventManager = $this->get('spec_shaper_calendar.manager.event');

        $event = $eventManager->createEvent();

        $form = $this->createForm(CalendarEventType::class, $event, array(
            'action' => $this->generateUrl('event_new'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newEvent = new CalendarEditEvent($event);

            $modifiedEventEntity = $loadedEvents = $this->getDispatcher()
                    ->dispatch(CalendarEvents::CALENDAR_NEW_EVENT, $newEvent)
                    ->getEventEntity();

            $em = $this->getDoctrine()->getManager();
            $em->persist($modifiedEventEntity);
            $em->flush();

            return new JsonResponse($modifiedEventEntity->toArray());
        }

        return $this->render('SpecShaperCalendarBundle:Calendar:eventModal.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Update an event with changes from the modal.
     *
     * @param Request $request
     * @param integer $id
     *
     * @return JsonResponse
     * @Route("/{id}/updateevent", name="event_update")
     * @Method({"GET","PUT"})
     */
    public function updateEventAction(Request $request, $id) {

        $event = $this->getEventManager()->getEvent($id);
        
        $orgionalAttendees = $this->getEventManager()->storeOrigionalAttendees($event->getCalendarAttendees());

        $form = $this->createForm(CalendarEventType::class, $event, array(
            'action' => $this->generateUrl('event_update', array('id' => $id)),
            'method' => 'PUT',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event = $this->getEventManager()->updateEvent($event, $orgionalAttendees);
            
            $newEvent = new CalendarEditEvent($event);

            $modifiedEventEntity = $this->getDispatcher()
                    ->dispatch(CalendarEvents::CALENDAR_EVENT_UPDATED, $newEvent)
                    ->getEventEntity();
                    
            return new JsonResponse($modifiedEventEntity->toArray());
        }

        return $this->render('SpecShaperCalendarBundle:Calendar:eventModal.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @Route("/{id}/deleteevent", name="event_delete")
     * @Method({"POST"})
     */
    public function deleteEventAction(Request $request) {
        
        $this->getEventManager()->deleteEvent($id);
        
        return new JsonResponse("deleted");
    }

    /**
     * Get the Calendar Event CalendarEventManager.
     *
     * @return CalendarEventManager
     */
    protected function getEventManager() {
        return $this->get('spec_shaper_calendar.manager.event');
    }

    /**
     * Get the EventDispatcher.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getDispatcher() {
        return $this->container->get('event_dispatcher');
    }

}
