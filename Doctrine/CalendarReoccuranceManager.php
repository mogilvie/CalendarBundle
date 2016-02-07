<?php

namespace SpecShaper\CalendarBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use SpecShaper\CalendarBundle\Model\CalendarEventInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;
use DateTime;
use SpecShaper\CalendarBundle\Model\CalendarReoccuranceInterface;
use SpecShaper\CalendarBundle\Doctrine\CalendarReoccuranceManager;

class CalendarReoccuranceManager {

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

    /**
     * Constructor.
     * 
     * @param EntityManager $em
     * @param string $class
     */
    public function __construct(EntityManager $em, $class) {
        $this->entityManager = $em;
        $this->repository = $em->getRepository($class);
        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * Returns a new CalendarEvent of the class defined in config.
     * 
     * @return CalendarEventInterface
     */
    public function createReoccurance() {
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
        $em = $this->entityManager;
        $em->persist($event);
        $em->flush();

        return $event;
    }

    public function createEventSeries(CalendarEventInterface $event) {

        $reoccurance = $event->getCalendarReoccurance();        
        $reoccurance->setStartDate($event->getStartDatetime());
        //$reoccurance->setEndDate($event->getEndDatetime());
        
        $eventDuration = $event->getStartDatetime()->diff($event->getEndDatetime());
        
        $eventDates = $this->getArrayOfStartDates($reoccurance);

        foreach ($eventDates as $startDate) {

            $this->processTime($startDate, $event->getStartDatetime());
                    

            $newEvent = clone $event;

            $newEvent
                    ->setStartDatetime($startDate)
                    ->setEndDatetime($startDate->add($eventDuration))
                    ->setCalendarReoccurance($reoccurance);
            $reoccurance->addCalendarEvent($newEvent);
            $this->entityManager->persist($newEvent);
        }

        // Get an array of all the StartDateTimes that the reoccurance requires
        // For each new date
        // Clone the event
        // Get the difference between the original event start and end date
        // Append the orgigonal start time to the new event start date
        // Add the differential to get an end date.
        // Add the new entity to the Reoccurance.
        // Save the entity.
    }

    public function getArrayOfStartDates(CalendarReoccuranceInterface $reoccurance) {

        $dateArray = array();

        switch ($reoccurance->getPeriod()) {
            case CalendarReoccuranceInterface::FREQUENCY_DAY:
                $period = 'D';
                break;
            case CalendarReoccuranceInterface::FREQUENCY_WEEK:
                $period = 'W';
                break;
            case CalendarReoccuranceInterface::FREQUENCY_MONTH:
                $period = 'M';
                break;
            case CalendarReoccuranceInterface::FREQUENCY_YEAR:
                $period = 'Y';
                break;
        }

        $date = $reoccurance->getStartDate();

        if ($reoccurance->getStopMethod() === CalendarReoccuranceInterface::END_DATE) {

            while ($date <= $reoccurance->getEndDate()) {

                $interval = new \DateInterval("P" . $reoccurance->getIntervalBetween() . $period);
                $date = $date->add($interval);
                $cloneDate = clone $date;
                $dateArray[] = $cloneDate;
            }
        }

        if ($reoccurance->getStopMethod() === CalendarReoccuranceInterface::END_ITERATIONS) {

            for ($x = 0; $x <= $reoccurance->getIterations(); $x++) {
                $interval = new \DateInterval("P" . $reoccurance->getIntervalBetween() . $period);
                $date = $date->add($interval);
                $cloneDate = clone $date;                
                $dateArray[] = $cloneDate;
            }
        }

        return $dateArray;
    }

    /**
     * Remove a CalendarEvent from the database.
     * 
     * @param CalendarEventInterface $event
     */
    public function deleteEvent(CalendarEventInterface $event) {

        $em = $this->entityManager;
        $em->remove($event);
        $em->flush();
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

}
