<?php

namespace SpecShaper\CalendarBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use SpecShaper\CalendarBundle\Model\CalendarEventInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;
use SpecShaper\CalendarBundle\Doctrine\CalendarReoccuranceManager;
use DateTime;

class CalendarEventManager {

    /**
     * @var EntityManager $entityManager;
     */
    protected $entityManager;

    /**
     * The user defined object CalendarEvent object class.
     * 
     * Set in config.yml and defined in the bundle by DependencyInjection
     * then passed via the service container.
     * 
     * @var string $class
     */
    protected $class;

    /**
     * The CalendarEvent entity repository.
     * 
     * @var EntityRepository $repository
     */
    protected $repository;

    /**
     * A temporary array of the original attendees when the event is loaded.
     * 
     * @var ArrayCollection $originalAttendees
     */
    protected $originalAttendees;

    /**
     * The original CalendarReoccurance id at time of loading.
     * 
     * @var integer $origionalReoccuranceId
     */
    protected $origionalReoccuranceId;
    protected $reoccuranceManager;

    /**
     * Constructor.
     * 
     * @param EntityManager $em
     * @param string $class
     */
    public function __construct(EntityManager $em, CalendarReoccuranceManager $reoccuranceManager, $class) {
        $this->entityManager = $em;
        $this->repository = $em->getRepository($class);
        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->getName();
        $this->reoccuranceManager = $reoccuranceManager;
    }

    /**
     * Returns a new CalendarEvent of the class defined in config.
     * 
     * @return CalendarEventInterface
     */
    public function createEvent() {
        $class = $this->class;
        return new $class();
    }

    /**
     * Get the CalendarEvent classname.
     * @return string
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * Get the CalendarEvent entity.
     * 
     * @param integer $id
     * @return CalendarEventInterface
     */
    public function getEvent($id) {
        return $this->repository->find($id);
    }

    /**
     * Save a calendar event.
     * 
     * @param  CalendarEventInterface $event
     * @return CalendarEventInterface
     */
    public function save(CalendarEventInterface $event) {

        if ($event->getIsReoccuring() === false) {
            $event->removeCalendarReoccurance();
        }

        if ($event->getIsReoccuring() && $event->getCalendarReoccurance() !== null) {
            $this->getReoccuranceManager()->createEventSeries($event);
        }

        $em = $this->entityManager;
        $em->persist($event);
        $em->flush();

        return $event;
    }

    /**
     * Update the DateTimes for the CalendarEvent.
     * 
     * Called by ajax when the user drags the calendar event, or resizes it in
     * the FullCalendar plugin.
     * 
     * @param FormInterface $form
     * @param CalendarEventInterface $event
     */
    public function updateDateTimes(FormInterface $form, CalendarEventInterface $event) {
        // Get the start date and time from the individual form fields.
        $startDate = $form->get('startDate')->getData();
        $startTime = $form->get('startTime')->getData();

        // Append the time to the date and set the result to the CalendarEvent entity.
        $startDatetime = $this->processTime($startDate, $startTime);
        $event->setStartDatetime($startDatetime);

        // Get the end date and time from the individual form fields.
        $endDate = $form->get('endDate')->getData();
        $endTtime = $form->get('endTime')->getData();

        // Append the time to the date and set the result to the CalendarEvent entity.
        $endDatetime = $this->processTime($endDate, $endTtime);
        $event->setEndDatetime($endDatetime);
    }

    /**
     * Function to append a time to a given date.
     * 
     * @param DateTime $date
     * @param DateTime $time
     * @return DateTime
     */
    private function processTime(DateTime $date, DateTime $time) {

        // Get the time as individual integers.
        $hour = $time->format('H');
        $minute = $time->format('i');
        $second = $time->format('s');

        // Set the time to the date.
        $datetime = $date->setTime($hour, $minute, $second);

        return $datetime;
    }

    /**
     * Function to temporarily store original loaded data for a CalendarEvent.
     * 
     * @param CalendarEventInterface $event
     */
    public function storeOrigionalData(CalendarEventInterface $event) {

        // Store the origional CalendarAttendees to this class variable.
        if (!$event->getCalendarAttendees()->isEmpty()) {
            $this->storeOrigionalAttendees($event);
        }

        // If there is a reoccurance, store the orgional reoccurance id.
        if ($event->getCalendarReoccurance() !== null) {
            $this->origionalReoccuranceId = $event->getCalendarReoccurance()->getId();
        }
    }

    /**
     * Store the original CalendarEvent attendees for use later.
     * 
     * Used when comparing the original vs modified CalendarEvent and then
     * remove any deselected CalendarAttendees from the database.
     * 
     * @param CalendarEventInterface $event
     */
    private function storeOrigionalAttendees(CalendarEventInterface $event) {

        $originalAttendees = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($event->getCalendarAttendees() as $attendee) {
            $originalAttendees->add($attendee);
        }

        $this->originalAttendees = $originalAttendees;
    }

    /**
     * Update a a modified CalendarEvent entity and persist;
     * 
     * @param CalendarEventInterface $event
     * @return CalendarEventInterface
     */
    public function updateEvent(CalendarEventInterface $event) {

        $em = $this->entityManager;

        // Check the original attendees, if they are no longer in the modified
        // event then remove them from the database.

        if ($this->originalAttendees !== null) {
            foreach ($this->originalAttendees as $attendee) {
                if (false === $event->getCalendarAttendees()->contains($attendee)) {
                    $em->remove($attendee);
                }
            }
        }

        // If there was orginally a reoccurance event, but the event is no longer checked as being reoccuring....
        if ($event->getIsReoccuring() === false) {

            if ($this->origionalReoccuranceId !== null) {

                // Get the original reoccurance entity.
                $reoccurance = $em->getRepository("AppBundle:CalendarReoccurance")->find($this->origionalReoccuranceId);

                // If there is only one CalendarEvent in the origional and it is this entity then delete it from the database.
                if ($reoccurance->getCalendarEvents()->count() === 1 && $reoccurance->getCalendarEvents()->contains($event)) {
                    $em->remove($reoccurance);
                }
            }

            $event->removeCalendarReoccurance();
        }


        if ($event->getIsReoccuring() && $event->getCalendarReoccurance() !== null) {

            $this->getReoccuranceManager()->createEventSeries($event);
        }

        $em->persist($event);

        $em->flush();

        return $event;
    }

    /**
     * Remove a CalendarEvent from the database.
     * 
     * @param CalendarEventInterface $event
     */
    public function deleteEvent(CalendarEventInterface $event) {
        $em = $this->entityManager;

        if ($event->getCalendarReoccurance() !== null) {            
            $event->removeCalendarReoccurance();
        }

        $deletedIdArray = [$event->getId()];


        $em->remove($event);
        $em->flush();

        return $deletedIdArray;
    }

    /**
     * Remove a CalendarEvent from the database.
     * 
     * @param CalendarEventInterface $event
     */
    public function deleteEventSeries(CalendarEventInterface $event) {

        $em = $this->entityManager;

        $reoccurance = $event->getCalendarReoccurance();

        $deletedIdArray = [];

        foreach ($reoccurance->getCalendarEvents() as $eventToRemove) {
            $deletedIdArray[] = $eventToRemove->getId();
            $em->remove($eventToRemove);
        }

        $em->remove($reoccurance);

        $em->flush();

        return $deletedIdArray;
    }

    /**
     * 
     * @return CalendarReoccuranceManager
     */
    protected function getReoccuranceManager() {
        return $this->reoccuranceManager;
    }

}
