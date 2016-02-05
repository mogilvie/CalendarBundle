<?php

namespace SpecShaper\CalendarBundle\Model;

/**
 * CalendarComment.
 */
interface CalendarCommentInterface
{
    /**
     * Constructor.
     */
    public function __construct();

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Add event.
     */
    public function addCalendarEvent(CalendarEventInterface $event);

    /**
     * Remove event.
     *
     */
     public function removeCalendarEvent(CalendarEventInterface $event);
     
     /**
     * Get event
     */
    public function getCalendarEvent();

    public function setCalendarAttendee(CalendarAttendeeInterface $attendee);

    public function getCalendarAttendee();
}
