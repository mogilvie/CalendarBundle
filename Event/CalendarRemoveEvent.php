<?php

/**
 * SpecShaperCalendarBundle\Event\CalendarRemoveEvent.php
 *  
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace SpecShaper\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use SpecShaper\CalendarBundle\Model\PersistedEventInterface;

/**
 * CalendarRemoveEvent dispatched whenever a CalendarEvent is removed/deleted.
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 */
class CalendarRemoveEvent extends Event
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
        
    }

    /**
     * Get the newly created event.
     * 
     * @return PersistedEventInterface
     */
    public function getEvent()
    {
        return $this->newEvent;
    }

}
