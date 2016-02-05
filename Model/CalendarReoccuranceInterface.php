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

/**
 * Description of CalendarReoccurance
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 * @copyright   (c) 2015, SpecShaper - All rights reserved
 * @license     http://URL name
 * @version     Release: 1.0.0
 * @since       Available since Release 1.0.0
 */
interface CalendarReoccuranceInterface {

    /**
     * Occur each sunday
     *
     * @var integer
     */
    const DAY_SUNDAY = 1;

    /**
     * Occur each monday
     *
     * @var integer
     */
    const DAY_MONDAY = 2;

    /**
     * Occur each tuesday
     *
     * @var integer
     */
    const DAY_TUESDAY = 3;

    /**
     * Occur each wednesday
     *
     * @var integer
     */
    const DAY_WEDNESDAY = 4;

    /**
     * Occur each thursday
     *
     * @var integer
     */
    const DAY_THURSDAY = 5;

    /**
     * Occur each friday
     *
     * @var integer
     */
    const DAY_FRIDAY = 6;

    /**
     * Occur each saturday
     *
     * @var integer
     */
    const DAY_SATURDAY = 7;

    /**
     * Occur at each days
     *
     * @var integer
     */
    const FREQUENCY_DAY = 0;

    /**
     * Occur at each weeks
     *
     * @var integer
     */
    const FREQUENCY_WEEK = 1;

    /**
     * Occur at each months
     *
     * @var integer
     */
    const FREQUENCY_MONTH = 2;

    /**
     * Occur at each years
     *
     * @var integer
     */
    const FREQUENCY_YEAR = 3;
    const END_ITERATIONS = 0;
    const END_DATE = 1;

    /**
     * 
     */
    public function __construct();

    /**
     * 
     */
    public function getId();

    /**
     *
     */
    public function addCalendarEvent(CalendarEventInterface $event);

    /**
     * 
     */
    public function removeCalendarEvent(CalendarEventInterface $event);

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\RecurrenceInterface::getEvent()
     */
    public function getCalendarEvents();

    /**
     * The frequency of calendarEvents.
     * 
     * Daily, Weekly, Monthly, Yearly as om the constants.
     * 
     * 
     * @param integer $array
     */
    public function setPeriod($frequency);

    /**
     * 
     * @return CalendarReoccuranceInterface
     */
    public function getPeriod();

    /**
     * The days that the event occurs on.
     * 
     * Sunday through saturday as in the constants.
     * 
     * @param array $days An array of integers representing days of the week.
     */
    public function setDays($days);

    /**
     * 
     * @return array An array of integers representing days of the week.
     */
    public function getDays();

    /**
     * Set the event start time.
     * 
     * @param DateTimeInterface $startTime
     */
    public function setStartTime(DateTimeInterface $startTime);

    /**
     * Get the event start time.
     * 
     * @return DateTimeInterface
     */
    public function getStartTime();

    /**
     * Set the event end time.
     * 
     * @param DateTimeInterface $endTime
     */
    public function setEndTime(DateTimeInterface $endTime);

    /**
     * Get the event end time.
     * 
     * @return DateTimeInterface
     */
    public function getEndTime();

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
    public function setIntervalBetween($intervalBetween);

    /**
     * 
     * @return integer
     */
    public function getIntervalBetween();

    /**
     * Set the method chosen to determine the last reoccurance.
     * 
     * Can be endDate or iterations as defined in the constants.
     * 
     * @param integer $stopMethod
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setStopMethod($stopMethod);

    /**
     * Get the method chosen to determine the last reoccurance.
     * 
     * Can be endDate or iterations as defined in the constants.
     * 
     * @return integer
     */
    public function getStopMethod();

    /**
     * Set the number of times that the reoccuring even will occur.
     * 
     * Can be null if using the endDate method.
     * 
     * @param integer $iterations
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setIterations($iterations);

    /**
     * Get the number of times that the reoccuring even will occur.
     *
     * Can be null if using the endDate method.
     * 
     * @return integer
     */
    public function getIterations();
    
    /**
     * Get the date set as the start date for calendarEvents to reoccur.
     *  
     * @param DateTimeInterface $endDate
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setStartDate(DateTimeInterface $startDate);

    /**
     * Get the date set as the start date for calendarEvents to reoccur.
     * 
     * 
     * @return DateTimeInterface
     */
    public function getStartDate();
    /**
     * Get the date set as the last date for calendarEvents to reoccur.
     * 
     * Can be null if using the iterations method.
     * 
     * @param DateTimeInterface $endDate
     * @return \SpecShaper\CalendarBundle\Model\CalendarReoccurance
     */
    public function setEndDate(DateTimeInterface $endDate);

    /**
     * Get the date set as the last date for calendarEvents to reoccur.
     * 
     * Can be null if using the iterations method.
     * 
     * @return DateTimeInterface
     */
    public function getEndDate();
}
