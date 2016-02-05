<?php

namespace SpecShaper\CalendarBundle\Model;

/**
 * CalendarAttendeeInterface.
 */
interface CalendarAttendeeInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();
    /**
     * Set meeting.
     *
     * @param string $meeting
     *
     * @return CalendarAttendee
     */
    public function setMeeting($meeting);

    /**
     * Get meeting.
     *
     * @return string
     */
    public function getMeeting();

    /**
     * Set emailAddress.
     *
     * @param string $emailAddress
     *
     * @return CalendarAttendee
     */
    public function setEmailAddress($emailAddress);

    /**
     * Get emailAddress.
     *
     * @return string
     */
    public function getEmailAddress();
    
        
    /**
     * Set isOptional.
     *
     * @param isOptional $isOptional
     *
     * @return CalendarAttendee
     */
    public function setIsOptional($isOptional);

    /**
     * Get isOptional.
     *
     * @return boolean
     */
    public function getIsOptional();

    /**
     * Set hasAccepted.
     *
     * @param string $hasAccepted
     *
     * @return CalendarAttendee
     */
    public function setHasAccepted($hasAccepted);

    /**
     * Get hasAccepted.
     *
     * @return string
     */
    public function getHasAccepted();
    
        /**
     * Set hasDenied.
     *
     * @param string $hasDenied
     *
     * @return CalendarAttendee
     */
    public function setHasDenied($hasDenied);

    /**
     * Get hasDenied.
     *
     * @return string
     */
    public function getHasDenied();
    
    

    /**
     * Set acceptedOn.
     *
     * @param \DateTime $acceptedOn
     *
     * @return CalendarAttendee
     */
    public function setAcceptedOn($acceptedOn);

    /**
     * Get acceptedOn.
     *
     * @return \DateTime
     */
    public function getAcceptedOn();

    /**
     * Set token.
     *
     * @param string $token
     *
     * @return CalendarAttendee
     */
    public function setToken($token);

    /**
     * Get token.
     *
     * @return string
     */
    public function getToken();

    /**
     * Set sentOn.
     *
     * @param \DateTime $sentOn
     *
     * @return CalendarAttendee
     */
    public function setSentOn($sentOn);

    /**
     * Get sentOn.
     *
     * @return \DateTime
     */
    public function getSentOn();

    /**
     * Set event.
     *
     * @return CalendarEventInterface
     */
    public function setCalendarEvent(CalendarEventInterface $event = null);

    /**
     * Get event.
     */
    public function getCalendarEvent();
}
