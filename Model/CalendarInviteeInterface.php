<?php

namespace SpecShaper\CalendarBundle\Model;

/**
 * CalendarInviteeInterface.
 */
interface CalendarInviteeInterface
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
     * @return CalendarInvitee
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
     * @return CalendarInvitee
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
     * @return CalendarInvitee
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
     * @return CalendarInvitee
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
     * @return CalendarInvitee
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
     * @return CalendarInvitee
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
     * @return CalendarInvitee
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
     * @return CalendarInvitee
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
