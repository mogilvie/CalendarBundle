<?php

namespace SpecShaper\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SpecShaper\CalendarBundle\Event\CalendarEvent;
use SpecShaper\CalendarBundle\Model\PersistedEventInterface;
use SpecShaper\MeetingBundle\Entity\PersistedEvent;
use SpecShaper\CalendarBundle\Form\PersistedEventType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use SpecShaper\CalendarBundle\Doctrine\PersistedEventManager;

/**
 * @Route("/calendar")
 */
class CalendarController extends Controller
{
    /**
     * Dispatch a CalendarEvent and return a JSON Response of any events returned.
     * 
     * @param Request $request
     * @return Response
     * @todo remove GET
     * @Route("/loader", name="calendar_loader")
     * @Method({"GET","POST"})
     */
    public function loadCalendarAction(Request $request)
    {
              
        $startDatetime = new \DateTime();
        $startDatetime->setTimestamp(strtotime($request->get('start')));
        
        $endDatetime = new \DateTime();
        $endDatetime->setTimestamp(strtotime($request->get('end')));
        
        $events = $this->container->get('event_dispatcher')->dispatch(CalendarEvent::CONFIGURE, new CalendarEvent($startDatetime, $endDatetime, $request))->getEvents();
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        $return_events = array();
        
        foreach($events as $event) {
            $return_events[] = $event->toArray();    
        }
                        
        $response->setContent(json_encode($return_events));
        
        return $response;
    }
    
    /**
     * Add a new calendar event.
     * 
     * @param Request $request
     * @return JsonResponse
     * 
     * @Route("/addevent", name="calendar_addevent")
     * @Method({"GET","POST"})
     */
    public function addEventAction(Request $request){
   
        $eventManager = $this->get('spec_shaper_calender.manager.persisted_event');

        $event  = $eventManager->createEvent();
        
        $form = $this->createForm(PersistedEventType::class, $event, array(
            'action' => $this->generateUrl('calendar_addevent'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);           

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();            

            return new JsonResponse($event->toArray());
        }

        return $this->render('SpecShaperCalendarBundle:Calendar:eventModal.html.twig', array(
                    'form' => $form->createView(),
        ));
        
    }
    
    /**
     * Update an event with changes from the modal.
     * 
     * @param Request $request
     * @param PersistedEventInterface $event
     * @return JsonResponse
     * @Route("/{id}/updateevent", name="calendar_updateevent")
     * @Method({"GET","PUT"})
     */

    public function updateEventAction(Request $request, $id){                
        
        $event = $this->getEventManager()->getEvent($id);
        
        $form = $this->createForm(PersistedEventType::class, $event, array(
            'action' => $this->generateUrl('calendar_updateevent', array('id'=> $event->getId())),
            'method' => "PUT"
        ));
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            
            return new JsonResponse($event->toArray());
        }
        
        return $this->render('SpecShaperCalendarBundle:Calendar:eventModal.html.twig', array(
                    'form' => $form->createView(),
        ));
        
    }
    
    /**
     * Update the date and times of an event.
     * 
     * Used when resizing or dragging a calendar event in the calendar.
     * 
     * @param Request $request
     * @param PersistedEventInterface $event
     * @return JsonResponse
     * @Route("/{id}/updatedatetime", name="calendar_updatedatetime")
     * @Method("PUT")
     */
    public function updateDateTimeAction(Request $request, $id){                
        
        $event = $this->getEventManager()->getEvent($id);
        
        $start = $request->request->get('start');
        $end = $request->request->get('end');
                
        $event
                ->setStartDatetime(new DateTime($start))
                ->setEndDatetime(new DateTime($end))
                ;

        $em = $this->getDoctrine()->getManager();        
        $em->persist($event);
        $em->flush();        
        
        return new JsonResponse($event->toArray());

        
    }
    
    /**
     * 
     * @param Request $request
     * @Route("/deleteevent", name="calendar_deleteevent")
     * @Method({"GET","POST"})
     */
    public function deleteEventAction(Request $request){
        
    }
    
    public function getEvent($param) {
        
    }
    
    /**
     * 
     * @return PersistedEventManager
     */
    protected function getEventManager(){
        return $this->get('spec_shaper_calender.manager.persisted_event');
    }
    
}
