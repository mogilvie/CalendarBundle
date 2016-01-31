<?php

namespace SpecShaper\CalendarBundle\Model;

use DateTime;

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
     * Set startDate.
     * 
     * @param DateTime $startDate
     *
     * @return \SpecShaper\CalendarBundle\Entity\CalendarEvent
     */
    public function setStartDate(DateTime $startDate);

    /**
     * Get startDate.
     *
     * @return DateTime
     */
    public function getStartDate();

    /**
     * Set startTime.
     *
     * @param DateTime $startTime
     *
     * @return CalendarEvent
     */
    public function setStartTime(DateTime $startTime);

    /**
     * Get startTime.
     *
     * @return DateTime
     */
    public function getStartTime();

    /**
     * Set endDate.
     *
     * @param DateTime $endDate
     *
     * @return CalendarEvent
     */
    public function setEndDate(DateTime $endDate);

    /**
     * Get endDate.
     *
     * @return DateTime
     */
    public function getEndDate();

    /**
     * Set endTime.
     *
     * @param DateTime $endTime
     *
     * @return CalendarEvent
     */
    public function setEndTime(DateTime $endTime);

    /**
     * Get endTime.
     *
     * @return DateTime
     */
    public function getEndTime();

    /**
     * Process and store the StartDatetime.
     * 
     * Uses the nonpersisted parameters to create a
     * combined DateTime
     */
    public function storeStartDatetime();

    /**
     * Process and store the EndDatetime.
     * 
     * Uses the nonpersisted parameters to create a
     * combined DateTime
     */
    public function storeEndDatetime();

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
     * Set title.
     *
     * @param string $title
     *
     * @return CalendarEvent
     */
    public function setTitle($title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    public function onPreFlush();

    /**
     * Set startDatetime.
     *
     * @param \DateTime $startDatetime
     *
     * @return CalendarEvent
     */
    public function setStartDatetime($startDatetime);

    /**
     * Get startDatetime.
     *
     * @return \DateTime
     */
    public function getStartDatetime();

    /**
     * Set endDatetime.
     *
     * @param \DateTime $endDatetime
     *
     * @return CalendarEvent
     */
    public function setEndDatetime($endDatetime);

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
     * @return CalendarEvent
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
     * @return CalendarEvent
     */
    public function setIsAllDay($isAllDay);

    /**
     * Get isAllDay.
     *
     * @return bool
     */
    public function getIsAllDay();

    /**
     * Set isReoccuring.
     *
     * @param bool $isReoccuring
     *
     * @return CalendarEvent
     */
    public function setIsReoccuring($isReoccuring);

    /**
     * Get isReoccuring.
     *
     * @return bool
     */
    public function getIsReoccuring();

    /**
     * Set repeatUntil.
     *
     * @param \DateTime $repeatUntil
     *
     * @return CalendarEvent
     */
    public function setRepeatUntil(DateTime $repeatUntil);

    /**
     * Get repeatUntil.
     *
     * @return \DateTime
     */
    public function getRepeatUntil();

    /**
     * Set period.
     *
     * @param int $period
     *
     * @return CalendarEvent
     */
    public function setPeriod($period);

    /**
     * Get period.
     *
     * @return int
     */
    public function getPeriod();

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return CalendarEvent
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
     * @return CalendarEvent
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
     * @return CalendarEvent
     */
    public function setCalendar(CalendarInterface $calendar = null);

    /**
     * Get calendar
     *
     * @return CalendarInterface
     */
    public function getCalendar();

    /**
     * Add invitee
     *
     * @param CalendarInviteeInterface $invitee
     *
     * @return CalendarEvent
     */
    public function addCalendarInvitee(CalendarInviteeInterface $invitee);

    /**
     * Remove invitees
     *
     * @param CalendarInviteeInterface $invitee
     */
    public function removeCalendarInvitee(CalendarInviteeInterface $invitee);

    /**
     * Get invitees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendarInvitees();

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
     * @return CalendarEvent
     */
    public function addCalendarComment(CalendarCommentInterface $comment);

    /**
     * Remove comment
     *
     * @param CalendarCommentInterface $comment
     */
    public function removeCalendarComment(CalendarCommentInterface $comment);
}