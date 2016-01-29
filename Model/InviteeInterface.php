<?php

namespace SpecShaper\CalendarBundle\Model;

/**
 * InviteeInterface.
 */
interface InviteeInterface
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
     * @return Invitee
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
     * @return Invitee
     */
    public function setEmailAddress($emailAddress);

    /**
     * Get emailAddress.
     *
     * @return string
     */
    public function getEmailAddress();

    /**
     * Set hasAccepted.
     *
     * @param string $hasAccepted
     *
     * @return Invitee
     */
    public function setHasAccepted($hasAccepted);

    /**
     * Get hasAccepted.
     *
     * @return string
     */
    public function getHasAccepted();

    /**
     * Set acceptedOn.
     *
     * @param \DateTime $acceptedOn
     *
     * @return Invitee
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
     * @return Invitee
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
     * @return Invitee
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
     * @return PersistedEventInterface
     */
    public function setEvent(PersistedEventInterface $event = null);

    /**
     * Get event.
     */
    public function getEvent();
}
