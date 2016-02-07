<?php

namespace SpecShaper\CalendarBundle\Model;

use DateTimeInterface;
use SpecShaper\CalendarBundle\Model\CalendarAttendeeInterface;
use SpecShaper\CalendarBundle\Model\CalendarCommentInterface;
use SpecShaper\CalendarBundle\Validator\Constraints as CalendarAssert;;

/**
 * CalendarEvent.
 * 
 * @CalendarAssert\LogicalEndDate
 */
abstract class CalendarEvent implements CalendarEventInterface {

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
     * The location of the calendar event.
     *
     * @var string
     */
    protected $location;

    /**
     * The calendar event start date and time.
     *
     * @var DateTimeInterface
     */
    protected $startDatetime;

    /**
     * The calendar event end date and time.
     *
     * @var DateTimeInterface
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
     * Is the event a reoccuring event.
     *
     * @todo Not implemented yet.
     */
    protected $isReoccuring = false;

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
     * Convert calendar event details to an array.
     *
     * Format is required to transmit the array to the FullCalendar javascript.
     *
     * @todo look at timezones.
     * @return array $event
     */
    public function toArray() {
        $event = array();
        $event['id'] = $this->id;

        $event['title'] = $this->title;

        if ($this->startDatetime !== null) {
            $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:s");
//        $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:s\Z");
        }

        if ($this->endDatetime !== null) {
            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:s");
//            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:s\Z");
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
     * Set title.
     *
     * @param string $title
     *
     * @return CalendarEvent
     */
    public function setCalendarReoccurance(CalendarReoccuranceInterface $reoccurance) {

        
        $reoccurance
                ->setStartDate($this->startDatetime)
                ->setStartTime($this->startDatetime)
                ->setEndTime($this->endDatetime)
                ->addCalendarEvent($this);
        
        $this->calendarReoccurance = $reoccurance;

        return $this;
    }

    public function removeCalendarReoccurance() {
        
        $this->calendarReoccurance = null;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getCalendarReoccurance() {
        return $this->calendarReoccurance;
    }

    /* -------------------End of Custom Content------------------------------- */

    /**
     * Constructor.
     */
    public function __construct() {
        $this->calendarattendees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->calendarComments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set location.
     *
     * @param string $location
     *
     * @return CalendarEvent
     */
    public function setLocation($location) {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location.
     *
     * @return string
     */
    public function getLocation() {
        return $this->location;
    }
    
    /**
     * Set title.
     *
     * @param string $title
     *
     * @return CalendarEvent
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set startDatetime.
     *
     * @param \DateTimeInterface $startDatetime
     *
     * @return CalendarEvent
     */
    public function setStartDatetime(DateTimeInterface $startDatetime) {

        $this->startDatetime = $startDatetime;

        return $this;
    }

    /**
     * Get startDatetime.
     *
     * @return \DateTimeInterface
     */
    public function getStartDatetime() {
        return $this->startDatetime;
    }

    /**
     * Set endDatetime.
     *
     * @param \DateTimeInterface $endDatetime
     *
     * @return CalendarEvent
     */
    public function setEndDatetime(DateTimeInterface $endDatetime) {

        $this->endDatetime = $endDatetime;

        return $this;
    }

    /**
     * Get endDatetime.
     *
     * @return \DateTimeInterface
     */
    public function getEndDatetime() {
        return $this->endDatetime;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return CalendarEvent
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set isAllDay.
     *
     * @param bool $isAllDay
     *
     * @return CalendarEvent
     */
    public function setIsAllDay($isAllDay) {
        $this->isAllDay = $isAllDay;

        return $this;
    }

    /**
     * Get isAllDay.
     *
     * @return bool
     */
    public function getIsAllDay() {
        return $this->isAllDay;
    }

    /**
     * Set isReoccuring.
     *
     * @param bool $isReoccuring
     *
     * @return CalendarEvent
     */
    public function setIsReoccuring($isReoccuring) {
        $this->isReoccuring = $isReoccuring;

        return $this;
    }

    /**
     * Get isReoccuring.
     *
     * @return bool
     */
    public function getIsReoccuring() {
        return $this->isReoccuring;
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return CalendarEvent
     */
    public function setText($text) {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set background color.
     *
     * @param string $bgColor
     *
     * @return CalendarEvent
     */
    public function setBgColor($bgColor) {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * Get background color.
     *
     * @return string
     */
    public function getBgColor() {
        return $this->bgColor;
    }

    /**
     * Set calendar
     *
     * @param CalendarInterface $calendar
     *
     * @return CalendarEvent
     */
    public function setCalendar(CalendarInterface $calendar = null) {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return CalendarInterface
     */
    public function getCalendar() {
        return $this->calendar;
    }

    /**
     * Add attendee
     *
     * @param CalendarAttendeeInterface $attendee
     *
     * @return CalendarEvent
     */
    public function addCalendarAttendee(CalendarAttendeeInterface $attendee) {
        $this->calendarAttendees->add($attendee);
        $attendee->setCalendarEvent($this);

        return $this;
    }

    /**
     * Remove attendee
     *
     * @param CalendarAttendeeInterface $attendee
     */
    public function removeCalendarAttendee(CalendarAttendeeInterface $attendee) {
        $this->calendarAttendees->removeElement($attendee);
    }

    /**
     * Get attendees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendarAttendees() {
        return $this->calendarAttendees;
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendarComments() {
        return $this->calendarComments;
    }

    /**
     * Add comments
     *
     * @param CalendarCommentInterface $comment
     *
     * @return CalendarEvent
     */
    public function addCalendarComment(CalendarCommentInterface $comment) {
        $this->calendarComments->add($comment);
        $comment->getCalendarEvent($this);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param CalendarCommentInterface $comment
     */
    public function removeCalendarComment(CalendarCommentInterface $comment) {
        $this->calendarComments->removeElement($comment);
    }

}
