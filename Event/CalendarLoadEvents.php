<?php

/**
 * SpecShaperCalendarBundle\Event\CalendarLoadEvents.php
 *  
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace SpecShaper\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use SpecShaper\CalendarBundle\Model\PersistedEventInterface;

/**
 * CalendarLoadEvents is thrown to allow the AppBundle to load and set
 * the events which fall between the view date range for the calendar.
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 */
class CalendarLoadEvents extends Event
{
    /**
     * @var \DateTime
     */
    private $startDatetime;

    /**
     * @var \DateTime
     */
    private $endDatetime;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var PersistedEventInterface[]
     */
    private $events;

    /**
     * Constructor method requires a start and end time for event listeners to use.
     * 
     * @param \DateTime $start Begin datetime to use
     * @param \DateTime $end   End datetime to use
     * @param Request $request
     */
    public function __construct(\DateTime $start, \DateTime $end, Request $request = null)
    {
        $this->startDatetime = $start;
        $this->endDatetime = $end;
        $this->request = $request;
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get the events from the CalendarLoadEvents event.
     * 
     * PersistedEvents, or CalendarEvents, and added to this CalendarLoadEvents
     * in the AppBundle EventListenr.
     * 
     * Use this method to get the loaded events in the CalendarController.
     * 
     * @return PersistedEventInterface[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * If the event isn't already in the list, add it.
     * 
     * Used in the AppBundle EventListener when adding queried events
     * to the CalenderLoadEvents event.
     * 
     * @param EventEntity $event
     *
     * @return CalendarEvent $this
     */
    public function addEvent(PersistedEventInterface $event)
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }

        return $this;
    }

    /**
     * Get start datetime for the period to be loaded.
     * 
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * Get end datetime for the period to be loaded.
     * 
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * Get request.
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
