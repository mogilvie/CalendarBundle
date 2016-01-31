<?php

/**
 * SpecShaperCalendarBundle\Event\CalendarEditEvent.php
 *  
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace SpecShaper\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use SpecShaper\CalendarBundle\Model\CalendarEventInterface;

/**
 * CalendarEditEvent dispatched whenever a new CalendarEvent is created or modified.
 * 
 * Note that the CalendarEvent startDatetime and endDateTime properties are only
 * created when the CalendarEvent is about to be flushed, via an entity lifecycle
 * event PreFlush method. This is called in the construct method to ensure its ready.
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 */
class CalendarEditEvent extends Event
{
    /**
     * @var CalendarEventInterface
     */
    private $calendarEvent;

    /**
     * Construct the Event and store the CalendarEvent.
     * 
     * @param CalendarEventInterface $calendarEvent
     */
    public function __construct(CalendarEventInterface $calendarEvent)
    {
        $this->calendarEvent = $calendarEvent;        
    }

    /**
     * Get the CalendarEvent.
     * 
     * @return CalendarEventInterface
     */
    public function getEventEntity()
    {
        return $this->calendarEvent;
    }
    
    /**
     * Set a different event if required.
     * 
     * @param CalendarEventInterface $calendarEvent
     * 
     * @return \SpecShaper\CalendarBundle\Event\CalendarEditEvent
     */
    public function setEventEntity(CalendarEventInterface $calendarEvent)
    {
        $this->calendarEvent = $calendarEvent;
                
        return $this;
    }

}
