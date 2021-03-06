<?php

namespace SpecShaper\CalendarBundle\Model;

use DateTime;

/**
 * Comment.
 */
interface CalendarInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    public function getCountry();

    public function setCountry($country);

    public function setTimeZone($timeZone);

    public function getTimeZone();

    public function setDateFormat($dateFormat);

    public function getDateFormat();

    public function setTimeFormat($timeFormat);

    public function getTimeFormat();

    public function setDefaultDuration($defaultDuration);

    public function getDefaultDuration();

    public function setOtherCalendarFormat($otherCalendarFormat);

    public function getOtherCalendarFormat();

    /**
     * Set createdOn.
     *
     * @param \DateTime $createdOn
     *
     * @return Comment
     */
    public function setCreatedOn(DateTime $createdOn);

    /**
     * Get createdOn.
     *
     * @return \DateTime
     */
    public function getCreatedOn();
    
        /**
     * Add calendarEvent
     *
     * @param CalendarEventInterface $calendarEvent
     *
     * @return Calendar
     */
    public function addCalendarEvent(CalendarEventInterface $calendarEvent);

    /**
     * Remove calendarEvent
     *
     * @param CalendarEventInterface $calendarEvent
     */
    public function removeCalendarEvent(CalendarEventInterface $calendarEvent);

    /**
     * Get calendarEvents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendarEvents();
}
