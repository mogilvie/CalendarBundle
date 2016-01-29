<?php

namespace SpecShaper\CalendarBundle\Model;

use DateTime;

/**
 * PersistedEvent.
 */
interface PersistedEventInterface
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
     * @return \SpecShaper\CalendarBundle\Entity\PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
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
     * @return PersistedEvent
     */
    public function setBgColor($bgColor);

    /**
     * Get background color.
     *
     * @return string
     */
    public function getBgColor();
    
    
    /**
     * Add invitee.
     
     *
     * @return PersistedEvent
     */
    public function addInvitee($invitee);

    /**
     * Remove invitee.
     */
    public function removeInvitee($invitee);

    /**
     * Get invitees.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvitees();

    /**
     * Add comment.
     *
     * @param \SpecShaper\CalendarBundle\Entity\EventComment $comment
     *
     * @return PersistedEvent
     */
    public function addComment(EventCommentInterface $comment);

    /**
     * Remove comment.
     *
     * @param \SpecShaper\CalendarBundle\Entity\EventComment $comment
     */
    public function removeComment(EventCommentInterface $comment);

    /**
     * Get comment.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComment();
}
