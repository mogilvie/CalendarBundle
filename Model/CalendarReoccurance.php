<?php

/**
 * \CalendarReoccurance.php
 * 
 * LICENSE: Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential. SpecShaper is an SaaS product and no license is
 * granted to copy or distribute the source files.
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 2 2016
 * @copyright  (c) 2016, SpecShaper - All rights reserved
 * @license    http://URL name
 * @version     Release: 1.0.0
 * @since       Available since Release 1.0.0
 */

namespace SpecShaper\CalendarBundle\Model;

use DateTimeInterface;

use SpecShaper\CalendarBundle\Model\CalendarReoccuranceInterface;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of CalendarReoccurance
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 * @copyright   (c) 2015, SpecShaper - All rights reserved
 * @license     http://URL name
 * @version     Release: 1.0.0
 * @since       Available since Release 1.0.0
 */
abstract class CalendarReoccurance implements CalendarReoccuranceInterface {

    /**
     * The recurence's id
     *
     * @var integer
     */
    protected $id;

    /**
     * The date of the first event.
     * 
     * @var DateTime
     */
    protected $startDate;

    /**
     * The frequency of calendarEvents.
     * 
     * Daily, Weekly, Monthly, Yearly as om the constants.
     * 
     * @var integer 
     */
    protected $period;

    /**
     * The days that the event occurs on.
     * 
     * Sunday through saturday as in the constants.
     * 
     * @var array $days
     */
    protected $days = array();

    /**
     * The event start time.
     * 
     * @var DateTime
     */
    protected $startTime;

    /**
     * The event end time.
     * 
     * @var DateTime
     */
    protected $endTime;

    /**
     * The period between calendarEvents.
     * 
     * For instance
     * - Weekly with an intervalBetween of 2 would be every two weeks.
     * - Monthly with an intervalBetween of 2 would be every two months.
     * 
     * @var integer 
     */
    protected $intervalBetween;

    /**
     * The method by which the reoccuring event is chosen to finish.
     * 
     * The calendarEvents will run until a set date, or for a set number of meetings.
     * 
     * @todo Consider how to implement a 'Never' option.
     * @var integer 
     */
    protected $stopMethod;

    /**
     * The number of reocurance of the event.
     * 
     * @var integer 
     */
    protected $iterations;

    /**
     * The date before which the calendarEvents will stop reoccuring.
     * 
     * @var DateTime
     */
    protected $endDate;

    /**
     * 
     */
    public function __construct() {
        $this->calendarEvents = new ArrayCollection();
        
    }

    /**
     * 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     */
    public function addCalendarEvent(CalendarEventInterface $event) {
        $this->calendarEvents->add($event);
    }

    /**
     * 
     */
    public function removeCalendarEvent(CalendarEventInterface $event) {       
        
        if (!$this->calendarEvents->isEmpty() && $this->calendarEvents->contains($event)) {
            
            if($this->calendarEvents->count() > 1){
            
             $this->calendarEvents->remove($event);
            } else {
                $this->calendarEvents= null;
            }
        }                 
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\RecurrenceInterface::getEvent()
     */
    public function getCalendarEvents() {
        return $this->calendarEvents;
    }

    /**
     * The frequency of calendarEvents.
     * 
     * Daily, Weekly, Monthly, Yearly as om the constants.
     * 
     * 
     * @param integer $array
     */
    public function setPeriod($frequency) {
        $this->period = $frequency;
        return $this;
    }

    /**
     * 
     * @return CalendarReoccuranceInterface
     */
    public function getPeriod() {
        return $this->period;
    }

    /**
     * The days that the event occurs on.
     * 
     * Sunday through saturday as in the constants.
     * 
     * @param array $days An array of integers representing days of the week.
     */
    public function setDays($days) {
        $this->days = $days;
        return $this;
    }

    /**
     * 
     * @return array An array of integers representing days of the week.
     */
    public function getDays() {
        return $this->days;
    }

    /**
     * Set the event start time.
     * 
     * @param DateTimeInterface $startTime
     */
    public function setStartTime(DateTimeInterface $startTime) {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * Get the event start time.
     * 
     * @return DateTimeInterface
     */
    public function getStartTime() {
        return $this->startTime;
    }

    /**
     * Set the event end time.
     * 
     * @param DateTimeInterface $endTime
     */
    public function setEndTime(DateTimeInterface $endTime) {
        $this->endTime = $endTime;
        return $this;
    }

    /**
     * Get the event end time.
     * 
     * @return DateTimeInterface
     */
    public function getEndTime() {
        return $this->endime;
    }

    /**
     * Set the period between calendarEvents.
     * 
     * For instance
     * - Weekly with an intervalBetween of 2 would be every two weeks.
     * - Monthly with an intervalBetween of 2 would be every two months.
     * 
     * @param integer $intervalBetween
     * 
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setIntervalBetween($intervalBetween) {
        $this->intervalBetween = $intervalBetween;
        return $this;
    }

    /**
     * 
     * @return integer
     */
    public function getIntervalBetween() {
        return $this->intervalBetween;
    }

    /**
     * Set the method chosen to determine the last reoccurance.
     * 
     * Can be endDate or iterations as defined in the constants.
     * 
     * @param integer $stopMethod
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setStopMethod($stopMethod) {
        $this->stopMethod = $stopMethod;
        return $this;
    }

    /**
     * Get the method chosen to determine the last reoccurance.
     * 
     * Can be endDate or iterations as defined in the constants.
     * 
     * @return integer
     */
    public function getStopMethod() {
        return $this->stopMethod;
    }

    /**
     * Set the number of times that the reoccuring even will occur.
     * 
     * Can be null if using the endDate method.
     * 
     * @param integer $iterations
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setIterations($iterations) {
        $this->iterations = $iterations;
        return $this;
    }

    /**
     * Get the number of times that the reoccuring even will occur.
     *
     * Can be null if using the endDate method.
     * 
     * @return integer
     */
    public function getIterations() {
        return $this->iterations;
    }
    
    /**
     * Get the date set as the start date for calendarEvents to reoccur.
     *  
     * @param DateTimeInterface $endDate
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setStartDate(DateTimeInterface $startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * Get the date set as the start date for calendarEvents to reoccur.
     * 
     * 
     * @return DateTimeInterface
     */
    public function getStartDate() {
        return $this->startDate;
    }

    /**
     * Get the date set as the last date for calendarEvents to reoccur.
     * 
     * Can be null if using the iterations method.
     * 
     * @param DateTimeInterface $endDate
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setEndDate(DateTimeInterface $endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Get the date set as the last date for calendarEvents to reoccur.
     * 
     * Can be null if using the iterations method.
     * 
     * @return DateTimeInterface
     */
    public function getEndDate() {
        return $this->endDate;
    }

}
