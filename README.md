# SpecShaperCalendarBundle


Currently using this bundle for payments at (https://www.parolla.ie)](https://www.parolla.ie) and (https://tools.parolla.ie)](https://tools.parolla.ie)

The SpecShaperCalendarBundle provides a calendar and appointment package for the Symfony2 
framework utilising the [fullcalendar](http://fullcalendar.io/) jquery plugin.

Features include:

- Written for Symfony verison 3.0.x
- Calendar entities can be stored via Doctrine ORM.
- Entities are mapped-superclasses to allow your AppBundle to add additional relationships.
- Events are generated to permit listener classes to intercept entities.
- FullCalendar jquery front end that can create, update and resize events via ajax.

**Warning**
- Only the calendar and events are currently implemented.
- This bundle has not been unit tested.
- It has only been running on a Symfony2 v3.0.1 project, and not backward
compatibility tested.

Features road map:

- [x] Modal popup to create and modify events
- [x] Provide color options
- [ ] A sidebar comments summary in modal
- [ ] An optional sidebar monthly summary in main page.
- [ ] Expand the events fired
- [ ] Integrate with a mailer

Work to complete:

- Create Managers for entities.
- Provide custom validators on forms
- Fully comment docBlocks
- Integrate comments
- Unit tests to be added
- Translation files are required for both backend and frontend 
- Support for MongoDB/CouchDB ODM or Propel

## Documentation

The source of the documentation is stored in the `Resources/doc/` folder
in this bundle.

## License

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

## About

CalendarBundle is a [SpecShaper](http://about.specshaper.com) bundle for managing project
appointments.

It is based on the [adesigns/calendar-bundle](https://github.com/adesigns/calendar-bundle) modified
and extended with additional functionality.

## Reporting an issue or a feature request

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/mogilvie/CalendarBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.

# Installation

## Step 1: Download the bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require specshaper/calendar-bundle dev-master
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## Step 2: Enable the bundle


Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new SpecShaper\CalendarBundle\SpecShaperCalendarBundle(),
        );
        // ...
    }
    // ...
}
```

## Step 2: Create the entities

The bundle requires entities to interact with the database and store information.
- Calendar
- CalendarEvent
- CalendarReoccurance
- CalendarAttendee
- CalendarComment

### Calendar entity

The bundle allows many calendars to be created with different properties such as:
- Local time zone
- Owner
- Other preferences

The entity should extend the mapped superclass. You can provide any additional
entity code as required to suit your application.

```php
<?php

/**
 * AppBundle\Entity\Calendar.php
 * 
 * @copyright  (c) 2016, SpecShaper - All rights reserved
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CalendarEvent;
use SpecShaper\CalendarBundle\Model\Calendar as BaseCalendar;

/**
 * A calendar entity to house information on the calendar container itself.
 * 
 * The class extends the model class in the SpecShaperCalendarBundle. See link.
 * 
 * @link    https://github.com/mogilvie/CalendarBundle/blob/master/Model/Calendar.php
 * @author  Mark Ogilvie <mark.ogilvie@specshaper.com>
 * 
 * @ORM\Table(name="calendar_calendar")
 * @ORM\Entity
 */
class Calendar extends BaseCalendar {
    // Add your own relationships and properties here...

    /**
     * The events that belong in this Calendar.
     * 
     * Required by SpecShaperCalendarBundle.
     * 
     * @ORM\ManyToMany(targetEntity="CalendarEvent", mappedBy="calendar")
     */
    protected $calendarEvents;

    /**
     * Constructor.
     * 
     * Required by SpecShaperCalendarBundle to call the parent constructor on the
     * mapped superclass.
     * 
     * Modify to suit your needs.
     */
    public function __construct() {
        parent::__construct();
    }


}

```

### CalendarEvent entity

The CalendarEvent entity contains all the information about a particular event
or event series. Information such as:
- The time and duration of the event.
- The text content
- Any attendees
- Display properties

The entity should extend the mapped superclass. You can provide any additional
entity code as required to suit your application.

```php
<?php

/**
 * AppBundle\Entity\CalendarEvent.php
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CalendarAttendee;
use AppBundle\Entity\CalendarComment;
use AppBundle\Entity\Calendar;
use Symfony\Component\Validator\Constraints\Valid;
use SpecShaper\CalendarBundle\Model\CalendarEvent as BaseEvent;
use AppBundle\Entity\CalendarReoccurance;

/**
 * A CalendarEvent is an appointment/meeting etc belonging to a Calendar.
 * 
 * Be wary of confusion between a CalendarEvent entity and a thown events.
 *
 * @link    https://github.com/mogilvie/CalendarBundle/blob/master/Model/CalendarComment.php
 * @author  Mark Ogilvie <mark.ogilvie@specshaper.com>
 * 
 * @ORM\Table(name="calendar_event")
 * @ORM\Entity
 */
class CalendarEvent extends BaseEvent
{

    /**
     * The calendar that this event belongs in.
     * 
     * Required by SpecShaperCalendarBundle.
     * 
     * @ORM\ManyToMany(targetEntity="Calendar", inversedBy="calendarEvents")
     */
    protected $calendar;
    
    /**
     * The people invited to this event.
     * 
     * Required by SpecShaperCalendarBundle.
     * 
     * @Valid
     * @ORM\OneToMany(targetEntity="CalendarAttendee", mappedBy="calendarEvent", cascade={"persist", "remove"})
     */
    protected $calendarAttendees;
    
    /**
     * Comments posted in response to this event.
     * 
     * Required by SpecShaperCalendarBundle.
     * 
     * @Valid
     * @ORM\OneToMany(targetEntity="CalendarComment", mappedBy="calendarEvent", cascade={"persist", "remove"})
     */
    protected $calendarComments;
    
    /**
     * Comments posted in response to this event.
     * 
     * Required by SpecShaperCalendarBundle.
     * 
     * @Valid
     * @ORM\ManyToOne(targetEntity="CalendarReoccurance", inversedBy="calendarEvent", cascade={"persist", "remove"})
     */
    protected $calendarReoccurance;
        
    /**
     * Constructor.
     * 
     * Required by SpecShaperCalendarBundle to call the parent constructor on the
     * mapped superclass.
     * 
     * Note that constructor for the arrays defined in this entity are already in the
     * parent mapped superclass construct and do not need to be created here.
     * 
     * Modify to suit your needs.
     */
    public function __construct()
    {
       parent::__construct();   
    }
    
    // Add your own relationships and properties below here..

}
```

### CalendarReoccurance entity

An entity that contains the reoccurance information for a series of 
CalendarEvents.

```php
<?php

/**
 * AppBundle\Entity\CalendarEvent.php
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CalendarAttendee;
use AppBundle\Entity\CalendarComment;
use AppBundle\Entity\Calendar;
use SpecShaper\CalendarBundle\Model\CalendarReoccurance as BaseReoccurance;

/**
 *
 * @link    https://github.com/mogilvie/CalendarBundle/blob/master/Model/CalendarComment.php
 * @author  Mark Ogilvie <mark.ogilvie@specshaper.com>
 * 
 * @ORM\Table(name="calendar_reoccurance")
 * @ORM\Entity
 */
class CalendarReoccurance extends BaseReoccurance
{
    /**
     * @ORM\OneToMany(targetEntity="CalendarEvent", mappedBy="calendarReoccurance")
     */
    protected $calendarEvents;
        
    /**
     * Constructor.
     * 
     * Required by SpecShaperCalendarBundle to call the parent constructor on the
     * mapped superclass.
     * 
     * Note that constructor for the arrays defined in this entity are already in the
     * parent mapped superclass construct and do not need to be created here.
     * 
     * Modify to suit your needs.
     */
    public function __construct()
    {
       parent::__construct();        
    }
    
    // Add your own relationships and properties below here..
   

}

```

### CalendarAttendee entity

The entity contains information about an event attendee, such as:
- The email address of the attendee.
- The invitation status

The attendee should be modified to include a reference to your user entity if
you have one.

The entity should extend the mapped superclass. You can provide any additional
entity code as required to suit your application.

```php
<?php

/**
 * AppBundle\Entity\CalendarAttendee.php
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CalendarEvent;
use SpecShaper\CalendarBundle\Model\CalendarAttendee as BaseAttendee;

/**
 * A CalendarAttendee is a entity who has been invited to a CalendarEvent.
 * 
 * The class holds information relating to the status of the invitation.
 *
 * @link    https://github.com/mogilvie/CalendarBundle/blob/master/Model/CalendarAttendee.php
 * @author  Mark Ogilvie <mark.ogilvie@specshaper.com>
 * 
 * @ORM\Table(name="calendar_attendee")
 * @ORM\Entity
 */
class CalendarAttendee extends BaseAttendee
{
    /**
     * The calendar that this event belongs in.
     * 
     * Required by SpecShaperCalendarBundle.
     * 
     * @ORM\ManyToOne(targetEntity="CalendarEvent", inversedBy="calendarAttendees")
     */
    protected $calendarEvent;
//    
//    /**
//     * Constructor.
//     * 
//     * Required by SpecShaperCalendarBundle to call the parent constructor on the
//     * mapped superclass.
//     * 
//     * Modify to suit your needs.
//     */
//    public function __construct()
//    {
//        parent::__construct();
//    }
    
    // Add your own relationships and properties below here..
}

```

### CalendarComment entity

The entity contains any comments or messages made about an event:
- The email address of the attendee who commented.
- The message

The entity should extend the mapped superclass. You can provide any additional
entity code as required to suit your application.

```php
<?php

/**
 * AppBundle\Entity\CalendarComment.php
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CalendarEvent;
use SpecShaper\CalendarBundle\Model\CalendarComment as BaseComment;

/**
 * Calendar comments are messages left on the CalendarEvent.
 *
 * @link    https://github.com/mogilvie/CalendarBundle/blob/master/Model/CalendarComment.php
 * @author  Mark Ogilvie <mark.ogilvie@specshaper.com>
 * 
 * @ORM\Table(name="calendar_comment")
 * @ORM\Entity 
 */
class CalendarComment extends BaseComment
{
    /**
     * The calendar that this event belongs in.
     * 
     * Required by SpecShaperCalendarBundle.
     * 
     * @ORM\ManyToOne(targetEntity="CalendarEvent", inversedBy="calendarAttendees")
     */
    protected $calendarEvent;
    
    /**
     * Constructor.
     * 
     * Required by SpecShaperCalendarBundle to call the parent constructor on the
     * mapped superclass.
     * 
     * Modify to suit your needs.
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    // Add your own relationships and properties below here..


}

```

## Step 3: Create listeners

Create listeners in your application to intercept events fired by the bundle and
modify / interact with the events.

### CalendarLoadEventsListener
The event is thrown when an CalendarEvent is first loaded and whenever the user changes the view
date range.

Used to query for and decorate CalendarEvents to be displayed in the calendar.

### CalendarNewEventListener
The event is thrown when an CalendarEvent in the calendar.

Used to populate and decorate the new CalendarEvent to customise it for your application.

### CalendarRemoveEventListener
The event is thrown when an CalendarEvent is deleted or removed.

Used to modify or remove the CalendarEvent to customise it for your application.

### CalendarUpdateEventListener
The event is thrown when an CalendarEvent is updated.

Used to modify or remove the CalendarEvent to customise it for your application. For
example:
- Send an email updating attendees.
- Change relationships.

See the documents section for more detail of the listeners available:

### CalendarGetAddressListener
The event is thrown when a the calendar is loaded. It allows the opportunity to
provide email addresses to the autocomplete attendee email input.

## Step 4: Configure the bundle

To configure the minimum settings you need to define the orm. Only Doctrine is
supported at the moment.

Then point the bundle at your custom Calendar entities.

See the full documentation for a full list of options.

```yml
// app/config/config.yml

# Calendar configuration
spec_shaper_calendar:
    db_driver: orm
    custom_classes:
        calendar_class: AppBundle\Entity\Calendar
        event_class:    AppBundle\Entity\CalendarEvent     
        attendee_class:  AppBundle\Entity\CalendarAttendee
        comment_class:  AppBundle\Entity\CalendarComment
        reoccurance_class:  AppBundle\Entity\CalendarReoccurance
```

You will also need to enable translations if not already configured:

```yml
// app/config/config.yml
framework:
    translator:      { fallbacks: ["%locale%"] }
```

## Step 5: Define the routes

Define any routing that you prefer. The controller can be placed behind a firewall
by defining a prefix protected by your security firewalls.

```yml
// app/config/routing.yml

spec_shaper_calendar:
    resource: "@SpecShaperCalendarBundle/Resources/config/routing.yml"
    prefix:   /

```

## Step 6: Integrate into one of your twig templates

The bundle requires:
- Jquery
- Moment
- Bootstrap 
- DatePicker
- FullCalendar

The links to css and js files are generated by including twig templates.

A typical twig template extending a bundle base.html.twig.

```twig
{# app/Resources/views/calendar/calendar.html.twig #}

{% extends 'base.html.twig' %}


{% block stylesheets %}
    
    {% include 'SpecShaperCalendarBundle:Calendar:styles.html.twig' %}    
    <style>
      #calendar-holder{
          width: 50%;
          height: 200px;
      }
    </style>
    
{% endblock %}

{% block body %}

    {% include 'SpecShaperCalendarBundle:Calendar:calendar.html.twig' %}    

{% endblock %}

{% block javascripts %}

    {% include 'SpecShaperCalendarBundle:Calendar:javascript.html.twig' %} 
 
    <script>
        Calendar.init({
            loader: "{{ url('calendar_loader') }}",
            new: "{{url('event_new')}}",
            update: "{{ url('event_update', {'id' : 'PLACEHOLDER'} ) }}",
            updateDateTime: "{{ url('event_updatedatetime', {'id' : 'PLACEHOLDER'} ) }}",
            delete: "{{ url('event_delete', {'id' : 'PLACEHOLDER'} ) }}",
            deleteSeries: "{{ url('event_deleteseries', {'id' : 'PLACEHOLDER'} ) }}",
        });
    </script>

{% endblock %}
```

## Step 7: Customise

Use the entities to customise the persisted information and integrate the calendars with your
application entities.

Apply security via the route firewalls, or for more granular security control use the event
listeners to manage access.

Overwrite the twig modal and calendar template in your own app\Resources\SpecShaperCalendarBundle
directory to change the modal displays.

Copy and modify the fullcalendar-settings.js file to provide custom javascript functionality.
Or simply extend your twig template javascript block.

