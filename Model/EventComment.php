<?php

namespace SpecShaper\CalendarBundle\Model;

/**
 * EventComment.
 */
abstract class EventComment implements EventCommentInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $event;

    /**
     * @var \DateTime
     */
    protected $createdOn;

    /**
     * @var string
     */
    protected $comment;

    protected $invitee;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->event = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add event.
     *
     * @param PersistedEventInterface $event
     *
     * @return EventComment
     */
    public function addEvent(PersistedEventInterface $event)
    {
        $this->event[] = $event;

        return $this;
    }

    /**
     * Remove event.
     *
     * @param PersistedEventInterface $event
     */
    public function removeEvent(PersistedEventInterface $event)
    {
        $this->event->removeElement($event);
    }

    /**
     * Get event.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function setInvitee(InviteeInterface $invitee)
    {
        $this->invitee = $invitee;

        return $this;
    }

    public function getInvitee()
    {
        return $this->invitee;
    }
}
