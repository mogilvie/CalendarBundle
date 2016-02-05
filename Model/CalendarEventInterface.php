<?php

namespace SpecShaper\CalendarBundle\Model;

use DateTimeInterface;
use SpecShaper\CalendarBundle\Model\CalendarReoccuranceInterface;

/**
 * CalendarEvent.
 */
interface CalendarEventInterface
{
    const REPEAT_DAILY = 0;
    const REPEAT_WEEKLY = 1;
    const REPEAT_FORTNIGHTLY = 2;
    const REPEAT_MONTHLY = 3;
    
    

    public function toArray();

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
     * Set location.
     *
     * @param string $location
     *
     * @return CalendarEvent
     */
    public function setLocation($location);

    /**
     * Get location.
     *
     * @return string
     */
    public function getLocation();
    
    /**
     * Set title.
     *
     * @param string $title
     *
     * @return CalendarEventInterface
     */
    public function setTitle($title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set startDatetime.
     *
     * @param \DateTimeInterface $startDatetime
     *
     * @return CalendarEventInterface
     */
    public function setStartDatetime(DateTimeInterface $startDatetime);

    /**
     * Get startDatetime.
     *
     * @return \DateTime
     */
    public function getStartDatetime();

    /**
     * Set endDatetime.
     *
     * @param \DateTimeInterface $endDatetime
     *
     * @return CalendarEventInterface
     */
    public function setEndDatetime(DateTimeInterface $endDatetime);

    /**
     * Get endDatetime.
     *
     * @return \DateTime
     */
    public function getEndDatetime();

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return CalendarEventInterface
     */
    public function setUrl($url);

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set isAllDay.
     *
     * @param bool $isAllDay
     *
     * @return CalendarEventInterface
     */
    public function setIsAllDay($isAllDay);

    /**
     * Get isAllDay.
     *
     * @return boolean
     */
    public function getIsAllDay();

    /**
     * Set isReoccuring.
     *
     * @param bool $isReoccuring
     *
     * @return CalendarEventInterface
     */
    public function setIsReoccuring($isReoccuring);

    /**
     * Get isReoccuring.
     *
     * @return bool
     */
    public function getIsReoccuring();

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return CalendarEventInterface
     */
    public function setText($text);

    /**
     * Get text.
     *
     * @return string
     */
    public function getText();

    /**
     * Set background color.
     *
     * @param string $bgColor
     *
     * @return CalendarEventInterface
     */
    public function setBgColor($bgColor);

    /**
     * Get background color.
     *
     * @return string
     */
    public function getBgColor();
    
       /**
     * Set calendar
     *
     * @param CalendarInterface $calendar
     *
     * @return CalendarEventInterface
     */
    public function setCalendar(CalendarInterface $calendar = null);

    /**
     * Get calendar
     *
     * @return CalendarInterface
     */
    public function getCalendar();

    /**
     * Add attendee
     *
     * @param CalendarAttendeeInterface $attendee
     *
     * @return CalendarEventInterface
     */
    public function addCalendarAttendee(CalendarAttendeeInterface $attendee);

    /**
     * Remove attendees
     *
     * @param CalendarAttendeeInterface $attendee
     */
    public function removeCalendarAttendee(CalendarAttendeeInterface $attendee);

    /**
     * Get attendees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendarAttendees();

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
        /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendarComments();    
    /**
     * Add comments
     *
     * @param CalendarCommentInterface $comment
     *
     * @return CalendarEventInterface
     */
    public function addCalendarComment(CalendarCommentInterface $comment);

    /**
     * Remove comment
     *
     * @param CalendarCommentInterface $comment
     */
    public function removeCalendarComment(CalendarCommentInterface $comment);
    
        /**
     * Set title.
     *
     * @param string $title
     *
     * @return CalendarEvent
     */
    public function setCalendarReoccurance(CalendarReoccuranceInterface $reoccurance);

    public function removeCalendarReoccurance();
    
    /**
     * Get title.
     *
     * @return string
     */
    public function getCalendarReoccurance();
}