<?php

namespace SpecShaper\CalendarBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use SpecShaper\CalendarBundle\Model\CalendarEventInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;

class CalendarEventManager {

    protected $objectManager;
    protected $class;
    protected $repository;
    protected $originalAttendees;
    protected $origionalReoccuranceId;

    /**
     * Constructor.
     * 
     * @param ObjectManager $em
     * @param string $class
     */
    public function __construct(EntityManager $em, $class) {
        $this->objectManager = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    public function createEvent() {
        $class = $this->class;

        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public function getClass() {
        return $this->class;
    }

    public function getEvent($id) {
        return $this->repository->find($id);
    }

    public function save(CalendarEventInterface $event) {
        $em = $this->objectManager;
        $em->persist($event);
        $em->flush();

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

    public function storeOrigionalData(CalendarEventInterface $event) {

        $this->storeOrigionalAttendees($event);

        if ($event->getCalendarReoccurance() !== null) {
            $this->origionalReoccuranceId = $event->getCalendarReoccurance()->getId();
        }
    }

    public function storeOrigionalAttendees(CalendarEventInterface $event) {

        $originalAttendees = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($event->getCalendarAttendees() as $attendee) {
            $originalAttendees->add($attendee);
        }

        $this->originalAttendees = $originalAttendees;
    }

    public function updateEvent(CalendarEventInterface $event) {

        $em = $this->objectManager;

        foreach ($this->originalAttendees as $attendee) {
            if (false === $event->getCalendarAttendees()->contains($attendee)) {
                $em->remove($attendee);
            }
        }

        if ($event->getIsReoccuring() === false && $this->origionalReoccuranceId !== null) {

            $reoccurance = $em->getRepository("AppBundle:CalendarReoccurance")->find($this->origionalReoccuranceId);

            if ($reoccurance->getCalendarEvents()->count() === 1) {
                $em->remove($reoccurance);
            }

            $event->removeCalendarReoccurance();
        }


        $em->persist($event);

        $em->flush();

        dump($event);

        return $event;
    }

    public function deleteEvent(CalendarEventInterface $event) {

        $em = $this->objectManager;
        $em->remove($event);
        $em->flush();
    }

}
