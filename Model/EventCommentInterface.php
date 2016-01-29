<?php

namespace SpecShaper\CalendarBundle\Model;

/**
 * EventComment.
 */
interface EventCommentInterface
{
    /**
     * Constructor.
     */
    public function __construct();

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Add event.
     */
    public function addEvent(PersistedEventInterface $event);

    /**
     * Remove event.
     *
     *\/
     public function removeEvent(PersistedEventInterface $event)
     {
     $this->event->removeElement($event);
     }
     
     /**
     * Get event
     */
    public function getEvent();

    public function setInvitee(InviteeInterface $invitee);

    public function getInvitee();
}
