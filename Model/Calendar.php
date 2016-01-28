<?php

namespace SpecShaper\CalendarBundle\Model;

use SpecShaper\CalendarBundle\Model\PersistedEventInterface;
use SpecShaper\CalendarBundle\Model\CalendarInterface;
use DateTime;

/**
 * Comment
 */
abstract class Calendar implements CalendarInterface {

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     */
    protected $event;

    /**
     * @var string
     *
     */
    protected $country;

    /**
     * @var string
     */
    protected $timeZone;
    protected $dateFormat;
    protected $timeFormat;
    protected $defaultDuration;
    protected $otherCalendarFormat;
    protected $createdOn;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getEvent() {
        return $this->event;
    }

    public function setEvent(PersistedEventInterface $event) {
        $this->event = $event;
        return $this;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    public function setTimeZone($timeZone) {
        $this->timeZone = $timeZone;
        return $this;
    }

    public function getTimeZone() {
        return $this->timeZone;
    }

    public function setDateFormat($dateFormat) {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    public function getDateFormat() {
        return $this->dateFormat;
    }

    public function setTimeFormat($timeFormat) {
        $this->timeFormat = $timeFormat;
        return $this;
    }

    public function getTimeFormat() {
        return $this->timeFormat;
    }

    public function setDefaultDuration($defaultDuration) {
        $this->defaultDuration = $defaultDuration;
        return $this;
    }

    public function getDefaultDuration() {
        return $this->defaultDuration;
    }

    public function setOtherCalendarFormat($otherCalendarFormat) {
        $this->otherCalendarFormat = $otherCalendarFormat;
        return $this;
    }

    public function getOtherCalendarFormat() {
        return $this->otherCalendarFormat;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Comment
     */
    public function setCreatedOn(DateTime $createdOn) {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn() {
        return $this->createdOn;
    }

}
