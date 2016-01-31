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
 * Public controller to expose invitations.
 * 
 * This controller should be kept public so that people with a valid token 
 * can view an event and accept or reject invitations.
 * 
 * @Route("/public")
 */
class PublicController extends Controller {
    
    /**
     * Action to display an invitation and offer the invitee the change to 
     * accept or reject.
     * 
     * @Route("/{hash}/getaddresses", name="public_view")
     * @Method({"GET","POST"})
     */
    public function viewInvitationAction($hash) {

        $addressEvent = new CalendarGetAddressesEvent();

        $addressArray = $this->getDispatcher()
                ->dispatch(CalendarEvents::CALENDAR_GET_ADDRESSES, $addressEvent)
                ->toArray();

        return $this->render('SpecShaperCalendarBundle:Calendar:emailAddressDatalist.html.twig', array(
                    'emailAddresses' => $addressArray
        ));
    }
    
    public function createCommentAction($hash) {
        
    }
    
    
    /**
     * Action to accept an invitation from an external source.
     * 
     * Used for accepteding from an email etc.
     * 
     * @Route("/{hash}/accept", name="public_accept")
     * @Method("POST")
     */
    public function acceptInvitationNameAction($hash) {
        
    }
    
    /**
     *
     * Action to accept an invitation from an external source.
     * 
     * Used for accepteding from an email etc.
     * 
     * @Route("/{hash}/reject", name="public_reject")
     * @Method("POST")
     */
    public function rejectInvitationNameAction($hash) {
        
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
