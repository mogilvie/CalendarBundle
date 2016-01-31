<?php

/**
 * SpecShaperCalendarBundle\Event\CalendarEditEvent.php
 *  
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace SpecShaper\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use SpecShaper\CalendarBundle\Model\EmailAddress;

/**
 * CalendarEditEvent dispatched whenever a new CalendarEvent is created or modified.
 * 
 * Note that the CalendarEvent startDatetime and endDateTime properties are only
 * created when the CalendarEvent is about to be flushed, via an entity lifecycle
 * event PreFlush method. This is called in the construct method to ensure its ready.
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 */
class CalendarGetAddressesEvent extends Event
{
    /**
     * @var CalendarEventInterface
     */
    private $emailAddress;

    /**
     * Construct the Event and store the CalendarEvent.
     * 
     * @param CalendarEventInterface $calendarEvent
     */
    public function __construct()
    {
        $this->emailAddress = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get the CalendarEvent.
     * 
     * @return CalendarEventInterface
     */
    public function getAddresses()
    {
        return $this->emailAddress;
    }
    
    public function addAddress(EmailAddress $address)
    {
         $this->emailAddress[] = $address;
         
         return $this;
    }
    public function toArray() {
        
        $addressArray = [];
        
        foreach ($this->emailAddress as $address){
            $addressArray[] = $address->toArray();
        }
        
        return $addressArray;
        
    }
    
    

}
