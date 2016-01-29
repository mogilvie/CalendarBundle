<?php

namespace SpecShaper\CalendarBundle\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PersistedEvent.
 */
abstract class PersistedEvent implements PersistedEventInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * The title of the calendar event.
     * 
     * @var string
     */
    protected $title;

    /**
     * The calendar event start date and time.
     * 
     * @var \DateTime
     */
    protected $startDatetime;

    /**
     * The calendar event end date and time.
     * 
     * @var \DateTime
     */
    protected $endDatetime;

    /**
     * A url address associated with the event.
     * 
     * @todo Not implemented yet.
     *
     * @var string
     */
    protected $url;

    /**
     * Is the event an allday event.
     *
     * @var bool
     */
    protected $isAllDay;

    /**
     * The invitees.
     * 
     * @var integer[]
     */
    protected $invitees;

    /**
     * Is the event a reoccuring event.
     * 
     * @todo Not implemented yet.
     */
    protected $isReoccuring = false;

    /**
     * Date to repeat the event until.
     * 
     * @todo Not implemented yet.
     *
     * @var \Date
     */
    protected $repeatUntil;

    /**
     * The period of reoccuring meetings.
     * 
     * @todo Not implemented yet.
     */
    protected $period;

    /**
     * The text content of the event.
     *
     * @var string
     */
    protected $text;

    /**
     * Comments on the event.
     * 
     * @todo Not implemented yet.
     */
    protected $comment;

    /**
     * @var string HTML color code for the bg color of the event label.
     */
    protected $bgColor;

    /**
     * @var string HTML color code for the foregorund color of the event label.
     */
    protected $fgColor;

    /**
     * @var string css class for the event label
     */
    protected $cssClass;

    /**
     * @var DateTime
     */
    protected $startDate;

    /**
     * @var DateTime
     */
    protected $startTime;

    /**
     * @var DateTime
     */
    protected $endDate;

    /**
     * @var DateTime
     */
    protected $endTime;

    /**
     * Convert calendar event details to an array.
     * 
     * Format is required to transmit the array to the FullCalendar javascript.
     *
     * @return array $event
     */
    public function toArray()
    {
        $event = array();
        $event['id'] = $this->id;

        $event['title'] = $this->title;
        $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:s\Z");

        if ($this->endDatetime !== null) {
            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:s\Z");
        }

        if ($this->url !== null) {
            $event['url'] = false;
        }

        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
            $event['borderColor'] = $this->bgColor;
        }

        if ($this->fgColor !== null) {
            $event['textColor'] = $this->fgColor;
        }

        if ($this->cssClass !== null) {
            $event['className'] = $this->cssClass;
        }

        $event['allDay'] = $this->isAllDay;

//        foreach ($this->otherFields as $field => $value) {
//            $event[$field] = $value;
//        }

        return $event;
    }

    /**
     * Set startDate.
     * 
     * @param DateTime $startDate
     *
     * @return \SpecShaper\CalendarBundle\Entity\PersistedEvent
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDatetime;
    }

    /**
     * Set startTime.
     *
     * @param DateTime $startTime
     *
     * @return PersistedEvent
     */
    public function setStartTime(DateTime $startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime.
     *
     * @return DateTime
     */
    public function getStartTime()
    {
        return $this->startDatetime;
    }

    /**
     * Set endDate.
     *
     * @param DateTime $endDate
     *
     * @return PersistedEvent
     */
    public function setEndDate(DateTime $endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDatetime;
    }

    /**
     * Set endTime.
     *
     * @param DateTime $endTime
     *
     * @return PersistedEvent
     */
    public function setEndTime(DateTime $endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime.
     *
     * @return DateTime
     */
    public function getEndTime()
    {
        return $this->endDatetime;
    }

    public function onPreFlush()
    {
        $this->storeEndDatetime();
        $this->storeStartDatetime();
    }

    /**
     * Process and store the StartDatetime.
     * 
     * Uses the nonpersisted parameters to create a
     * combined DateTime
     */
    public function storeStartDatetime()
    {
        if ($this->startTime === null) {
            return;
        }

        $hour = $this->startTime->format('H');
        $minute = $this->startTime->format('i');
        $second = $this->startTime->format('s');

        $startDate = $this->startDate->setTime($hour, $minute, $second);

        $this->startDatetime = $startDate;
    }

    /**
     * Process and store the EndDatetime.
     * 
     * Uses the nonpersisted parameters to create a
     * combined DateTime
     */
    public function storeEndDatetime()
    {
        if ($this->endTime === null) {
            return;
        }

        $hour = $this->endTime->format('H');
        $minute = $this->endTime->format('i');
        $second = $this->endTime->format('s');

        $endDate = $this->endDate->setTime($hour, $minute, $second);

        $this->endDatetime = $endDate;
    }

    /* -------------------End of Custom Content------------------------------- */

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->invitees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return PersistedEvent
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set startDatetime.
     *
     * @param \DateTime $startDatetime
     *
     * @return PersistedEvent
     */
    public function setStartDatetime($startDatetime)
    {
        $this->startDatetime = $startDatetime;

        return $this;
    }

    /**
     * Get startDatetime.
     *
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * Set endDatetime.
     *
     * @param \DateTime $endDatetime
     *
     * @return PersistedEvent
     */
    public function setEndDatetime($endDatetime)
    {
        $this->endDatetime = $endDatetime;

        return $this;
    }

    /**
     * Get endDatetime.
     *
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return PersistedEvent
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set isAllDay.
     *
     * @param bool $isAllDay
     *
     * @return PersistedEvent
     */
    public function setIsAllDay($isAllDay)
    {
        $this->isAllDay = $isAllDay;

        return $this;
    }

    /**
     * Get isAllDay.
     *
     * @return bool
     */
    public function getIsAllDay()
    {
        return $this->isAllDay;
    }

    /**
     * Set isReoccuring.
     *
     * @param bool $isReoccuring
     *
     * @return PersistedEvent
     */
    public function setIsReoccuring($isReoccuring)
    {
        $this->isReoccuring = $isReoccuring;

        return $this;
    }

    /**
     * Get isReoccuring.
     *
     * @return bool
     */
    public function getIsReoccuring()
    {
        return $this->isReoccuring;
    }

    /**
     * Set repeatUntil.
     *
     * @param \DateTime $repeatUntil
     *
     * @return PersistedEvent
     */
    public function setRepeatUntil(DateTime $repeatUntil)
    {
        $this->repeatUntil = $repeatUntil;

        return $this;
    }

    /**
     * Get repeatUntil.
     *
     * @return \DateTime
     */
    public function getRepeatUntil()
    {
        return $this->repeatUntil;
    }

    /**
     * Set period.
     *
     * @param int $period
     *
     * @return PersistedEvent
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period.
     *
     * @return int
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return PersistedEvent
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Set background color.
     *
     * @param string $bgColor
     *
     * @return PersistedEvent
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * Get background color.
     *
     * @return string
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * Add invitee.
     *
     
     *
     * @return PersistedEvent
     */
    public function addInvitee($invitee)
    {
        $this->invitees[] = $invitee;

        return $this;
    }

    /**
     * Remove invitee.
     */
    public function removeInvitee($invitee)
    {
        $invitees = new ArrayCollection($this->invitees);
        
        $invitees->removeElement($invitee);

        $this->invitees = $invitees->toArray();
        
        return $this;
        
    }

    /**
     * Get invitees.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvitees()
    {
        return $this->invitees;
    }

    /**
     * Add comment.
     *
     * @param \SpecShaper\CalendarBundle\Entity\EventComment $comment
     *
     * @return PersistedEvent
     */
    public function addComment(EventCommentInterface $comment)
    {
        $this->comment[] = $comment;

        return $this;
    }

    /**
     * Remove comment.
     *
     * @param \SpecShaper\CalendarBundle\Entity\EventComment $comment
     */
    public function removeComment(EventCommentInterface $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get comment.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComment()
    {
        return $this->comment;
    }
}
