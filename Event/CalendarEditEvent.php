<?php

/**
 * SpecShaperCalendarBundle\Event\CalendarEditEvent.php
 *  
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace SpecShaper\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use SpecShaper\CalendarBundle\Model\PersistedEventInterface;

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
     * @var PersistedEventInterface
     */
    private $calendarEvent;

    /**
     * Construct the Event and store the CalendarEvent.
     * 
     * @param PersistedEventInterface $calendarEvent
     */
    public function __construct(PersistedEventInterface $calendarEvent)
    {
        $this->calendarEvent = $calendarEvent;
        
        // Make sure that the start and end dates are created.
        $calendarEvent->onPreFlush();
    }

    /**
     * Get the CalendarEvent.
     * 
     * @return PersistedEventInterface
     */
    public function getEventEntity()
    {
        return $this->calendarEvent;
    }
    
    /**
     * Set a different event if required.
     * 
     * @param PersistedEventInterface $calendarEvent
     * 
     * @return \SpecShaper\CalendarBundle\Event\CalendarEditEvent
     */
    public function setEventEntity(PersistedEventInterface $calendarEvent)
    {
        $this->calendarEvent = $calendarEvent;
        
        return $this;
    }

}
