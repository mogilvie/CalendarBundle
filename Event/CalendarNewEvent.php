<?php

/**
 * SpecShaperCalendarBundle\Event\CalendarNewEvent.php
 *  
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace SpecShaper\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use SpecShaper\CalendarBundle\Model\PersistedEventInterface;

/**
 * CalendarNewEvent dispatched whenever a new CalendarEvent is created.
 * 
 * Note that the CalendarEvent startDatetime and endDateTime properties are only
 * created when the CalendarEvent is about to be flushed, via an entity lifecycle
 * event PreFlush method. Thisis called in the constructure to ensure its ready.
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 */
class CalendarNewEvent extends Event
{
    /**
     * @var PersistedEventInterface
     */
    private $newEvent;

    /**
     * Construct the Event and store the CalendarEvent.
     * 
     * @param PersistedEventInterface $newEvent
     */
    public function __construct(PersistedEventInterface $newEvent)
    {
        $this->newEvent = $newEvent;
        
        // Make sure that the start and end dates are created.
        $newEvent->onPreFlush();
    }

    /**
     * Get the newly created event.
     * 
     * @return PersistedEventInterface
     */
    public function getEventEntity()
    {
        return $this->newEvent;
    }
    
    /**
     * Set a different event if required.
     * 
     * @param PersistedEventInterface
     * 
     * @return \SpecShaper\CalendarBundle\Event\CalendarNewEvent
     */
    public function setEventEntity(PersistedEventInterface $newEvent)
    {
        $this->newEvent = $newEvent;
        
        return $this;
    }

}
