<?php

namespace SpecShaper\CalendarBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use SpecShaper\CalendarBundle\Model\CalendarEventInterface;
use AppBundle\Entity\CalendarInvitee;
use Doctrine\Common\Collections\ArrayCollection;

class CalendarEventManager
{
    protected $objectManager;
    protected $class;
    protected $repository;
    protected $originalInvitees;

    /**
     * Constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param CanonicalizerInterface  $usernameCanonicalizer
     * @param CanonicalizerInterface  $emailCanonicalizer
     * @param ObjectManager           $om
     * @param string                  $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    public function createEvent()
    {
        $class = $this->class;

        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    public function getEvent($id)
    {
        return $this->repository->find($id);
    }

    public function save(CalendarEventInterface $event)
    {
        $om = $this->objectManager;
        
//        foreach($event->getCalendarInvitees() as $invitee)
//            
//            $invitee->setCalendarEvent($event);
//        
        
        
        $om->persist($event);
        $om->flush();

        return $event;
    }
    
    public function storeOrigionalInvitees($invitees) {

        $originalInvitees = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($invitees as $invitee) {
            $originalInvitees->add($invitee);
        }
        
        return $originalInvitees;
    }
    
    public function updateEvent(CalendarEventInterface $event, $originalInvitees) {
        
        $om = $this->objectManager;
        
         // remove the relationship between the tag and the Task
        foreach ($originalInvitees as $invitee) {
            if (false === $event->getCalendarInvitees()->contains($invitee)) {
                

                // if it was a many-to-one relationship, remove the relationship like this
                // $tag->setTask(null);

                $om->remove($invitee);

                // if you wanted to delete the Tag entirely, you can also do that
                // $em->remove($tag);
            }
        }
        $om->persist($event);
        $om->flush();
        
        return $event;
        
        
    }
    
    
    
}
