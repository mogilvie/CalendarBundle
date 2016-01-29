# Event listeners

Create listeners in your application to intercept events fired by the bundle and
modify / interact with the events.

## CalendarLoadEventsListener
Thrown when the calendar is first loaded and whenever the user changes the view
date range.

Used to query for and decorate CalendarEvents to be displayed in the calendar.

```php
<?php

/**
 * AppBundle\Listener\CalendarLoadEventsListener.php.
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 *
 */
namespace AppBundle\Listener;

use SpecShaper\CalendarBundle\Event\CalendarLoadEvents;
use Doctrine\ORM\EntityManager;

/**
 * CalendarLoadEventsListener loads the events for a given view period.
 * 
 * This listener is fired when ever a calendar view is loaded via an ajax call
 * from the FullCalendar jquery settings file.
 * 
 * Use this listener to query your CalendarEvent repository and select the
 * CalendarEvents that are to be displayed in the given date range.
 * 
 * Decorate or modify the CalendarEvents as desired.
 *
 */
class CalendarLoadEventsListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor with EntityManager passed from the CalendarController.
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Load CalendarEvents within a given date range.
     * 
     * @param CalendarLoadEvents $calendarLoadEvent
     */
    public function loadEvents(CalendarLoadEvents $calendarLoadEvent)
    {
        // The start of the Calendar view date range.
        $startDate = $calendarLoadEvent->getStartDatetime();
        
        // The end of the Calendar view date range.
        $endDate = $calendarLoadEvent->getEndDatetime();

        // The original request so you can get filters from the calendar
        $request = $calendarLoadEvent->getRequest();
        // Use the filter in your query for example
        $filter = $request->get('filter');

        // Load events using your custom logic here, or call a repository.
        $persistedEvents = $this->entityManager->getRepository('AppBundle:CalendarEvent')
                          ->createQueryBuilder('e')
                          ->where('e.startDatetime BETWEEN :startDate and :endDate')
                          ->setParameter('startDate', $startDate)
                          ->setParameter('endDate', $endDate)
                          ->getQuery()->getResult();
        

        // Add each of the queried events to this CalendarLoadEvents entity.
        // The events are then available in the CalendarController.
        foreach ($persistedEvents as $persistedEvent) {

//            //optional calendar event settings
//            $persistedEvent->setAllDay(true); // default is false, set to true if this is an all day event
//            $persistedEvent->setBgColor('#FF0000'); //set the background color of the event's label
//            $persistedEvent->setFgColor('#FFFFFF'); //set the foreground color of the event's label
//            $persistedEvent->setUrl('http://www.google.com'); // url to send user to when event label is clicked
//            $persistedEvent->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels

            //finally, add the persistedEvent to the CalendarLoadEvent for displaying on the calendar
            $calendarLoadEvent->addEvent($persistedEvent);
        }
    }
}
```

Register the listener in your services configuration file:

```yml
// app\config\services.yml

services:
    spec_shaper_calendar.load_events_listener:
        class: AppBundle\Listener\CalendarLoadEventsListener
        arguments:
            - '@doctrine.orm.entity_manager'
        tags:
            - { name: 'kernel.event_listener', event: 'specshaper_calendar.load_events', method: loadEvents }
```


## CalendarNewEventListener
Thrown when a new event is created in the calendar.

Used to populate and decorate the new CalendarEvent to customise it for your application.

```php
<?php

/**
 * AppBundle\Listener\CalendarNewEventListener.php.
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */
namespace AppBundle\Listener;

use Doctrine\ORM\EntityManager;
use SpecShaper\CalendarBundle\Event\CalendarNewEvent;

/**
 * CalendarNewEventListener catches newly created CalendarNewEvents.
 * 
 * The listener catches the CalendarNewEvent which contains the CalendarEvent
 * which has just been created.
 * 
 * Get the new CalendarEvent entity and modify it as required tosuit your application.
 * 
 * The CalendarController then retrives the modified entity, persists it, then
 * returns it to the calendar to display.
 * 
 */
class CalendarNewEventListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor with EntityManager passed from the CalendarController.
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Load CalendarEvents within a given date range.
     * 
     * @param CalendarNewEvent $calendarNewEvent
     */
    public function newEventEntity(CalendarNewEvent  $calendarNewEvent)
    {
        
        // Modify or set information to your new entity here.
        
        // $newCalendarEventEntity = $calendarNewEvent->getEventEntity();
        // $newCalendarEventEntity->setTitle("My revised title");
    }
}
```

Register the listener in your services configuration file:

```yml
// app\config\services.yml

services:
    spec_shaper_calendar.new_event_listener:
        class: AppBundle\Listener\CalendarNewEventListener
        arguments:
            - '@doctrine.orm.entity_manager'
        tags:
            - { name: 'kernel.event_listener', event: 'specshaper_calendar.new_event', method: newEventEntity }
```

## CalendarRemoveEventListener
Thrown when an event is deleted or removed.

Used to modify or remove the CalendarEvent to customise it for your application.

## CalendarUpdateEventListener
Thrown when an event is modified.

Used to modify or remove the CalendarEvent to customise it for your application. For
example:
- Send an email updating invitees.
- Change relationships.

See the documents section for more detail of the listeners available: