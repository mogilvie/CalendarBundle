<?php

namespace SpecShaper\CalendarBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use SpecShaper\CalendarBundle\Model\CalendarEventInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;

class CalendarEventManager
{
    protected $objectManager;
    protected $class;
    protected $repository;
    protected $originalInvitees;

    /**
     * Constructor.
     * 
     * @param ObjectManager $om
     * @param string $class
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
        $om->persist($event);
        $om->flush();

        return $event;
    }
    
    public function updateDateTimes(FormInterface $form, CalendarEventInterface $event) {
        $startDate = $form->get('startDate')->getData();
        $startTime = $form->get('startTime')->getData();
        
        $startDatetime = $this->processTime($startDate, $startTime);
        $event->setStartDatetime($startDatetime);
        
        $endDate = $form->get('endDate')->getData();
        $endTtime = $form->get('endTime')->getData();
        
        $endDatetime = $this->processTime($endDate, $endTtime);
        $event->setEndDatetime($endDatetime);   
    }
   
    public function processTime($date, $time) {

        $hour = $time->format('H');
        $minute = $time->format('i');
        $second = $time->format('s');

        $datetime = $date->setTime($hour, $minute, $second);

        return $datetime;
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

        foreach ($originalInvitees as $invitee) {
            if (false === $event->getCalendarInvitees()->contains($invitee)) {
                $om->remove($invitee);
            }
        }
        
        $om->persist($event);
        $om->flush();
        
        return $event;
        
        
    }
    
    
    
}
