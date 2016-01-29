<?php

namespace SpecShaper\CalendarBundle\Model;

/**
 * Invitee.
 */
class Invitee implements InviteeInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $event;

    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var string
     */
    protected $hasAccepted;

    /**
     * @var \DateTime
     */
    protected $acceptedOn;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \DateTime
     */
    protected $sentOn;

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
     * Set meeting.
     *
     * @param string $meeting
     *
     * @return Invitee
     */
    public function setMeeting($meeting)
    {
        $this->meeting = $meeting;

        return $this;
    }

    /**
     * Get meeting.
     *
     * @return string
     */
    public function getMeeting()
    {
        return $this->meeting;
    }

    /**
     * Set emailAddress.
     *
     * @param string $emailAddress
     *
     * @return Invitee
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress.
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set hasAccepted.
     *
     * @param string $hasAccepted
     *
     * @return Invitee
     */
    public function setHasAccepted($hasAccepted)
    {
        $this->hasAccepted = $hasAccepted;

        return $this;
    }

    /**
     * Get hasAccepted.
     *
     * @return string
     */
    public function getHasAccepted()
    {
        return $this->hasAccepted;
    }

    /**
     * Set acceptedOn.
     *
     * @param \DateTime $acceptedOn
     *
     * @return Invitee
     */
    public function setAcceptedOn($acceptedOn)
    {
        $this->acceptedOn = $acceptedOn;

        return $this;
    }

    /**
     * Get acceptedOn.
     *
     * @return \DateTime
     */
    public function getAcceptedOn()
    {
        return $this->acceptedOn;
    }

    /**
     * Set token.
     *
     * @param string $token
     *
     * @return Invitee
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set sentOn.
     *
     * @param \DateTime $sentOn
     *
     * @return Invitee
     */
    public function setSentOn($sentOn)
    {
        $this->sentOn = $sentOn;

        return $this;
    }

    /**
     * Get sentOn.
     *
     * @return \DateTime
     */
    public function getSentOn()
    {
        return $this->sentOn;
    }

    /**
     * Set event.
     *
     * @param PersistedEventInterface $event
     *
     * @return Invitee
     */
    public function setEvent(PersistedEventInterface $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return PersistedEventInterface
     */
    public function getEvent()
    {
        return $this->event;
    }
}
