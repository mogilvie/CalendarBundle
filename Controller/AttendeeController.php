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
 * @Route("/attendee")
 */
class AttendeeController extends Controller {
    
    /**
     *
     * @Route("/getaddresses", name="calendar_getaddresses")
     * @Method("GET")
     */
    public function getEmailAddressesAction() {

        $addressEvent = new CalendarGetAddressesEvent();

        $addressArray = $this->getDispatcher()
                ->dispatch(CalendarEvents::CALENDAR_GET_ADDRESSES, $addressEvent)
                ->toArray();

        return $this->render('SpecShaperCalendarBundle:Calendar:emailAddressDatalist.html.twig', array(
                    'emailAddresses' => $addressArray
        ));
    }
    
    

    /**
     * Get the Calendar Event CalendarEventManager.
     *
     * @return CalendarEventManager
     */
    protected function getEventManager() {
        return $this->get('spec_shaper_calendar.manager.calendar_event');
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
