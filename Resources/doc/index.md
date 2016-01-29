# SpecShaperCalendarBundle

The SpecShaperCalendarBundle provides a calendar and appointment package for the Symfony2 
framework utilising the [fullcalendar](http://fullcalendar.io/) jquery plugin.

Features include:

- Written for Symfony verison 3.0.x
- Calendar entities can be stored via Doctrine ORM.
- Entities are mapped-superclasses to allow your AppBundle to add additional relationships.
- Events are generated to permit listener classes to intercept entities.
- FullCalendar jquery front end that can create, update and resize events via ajax.

**Warning**
- This bundle has not been unit tested.
- It has only been running on a Symfony2 v3.0.1 project, and not backward
compatibility tested.

Features road map:

- [x] Modal popup to create and modify events
- [ ] A sidebar comments summary in modal
- [ ] An optional sidebar monthly summary in main page.
- [ ] Expand the events fired
- [ ] Integrate with a mailer

Work to complete:

- Provide custom validators on forms
- Fully comment docBlocks
- Integrate invitees and comments
- Implement event series
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
- Event
- Invitee
- Comment

### Calendar entity

The bundle allows many calendars to be created with different properties such as:
- Local time zone
- Owner
- Other preferences

The entity should extend the mapped superclass. You can provide any additional
entity code as required to suit your application.

```php
<?php
// src/AppBundle/Entity/Calendar.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\CalendarBundle\Model\Calendar as BaseCalendar;

/**
 * A calendar to house events and define calendar properties. 
 *
 * @ORM\Entity
 */
class Calendar extends BaseCalendar{

    // Extend the calendar with additional application specific code...

    public function __construct()
    {        
        parent::__construct();
        //...
    }
}
```

### CalendarEvent entity

The CalendarEvent entity contains all the information about a particular event
or event series. Information such as:
- The time and duration of the event.
- The text content
- Any invitees
- Display properties

The entity should extend the mapped superclass. You can provide any additional
entity code as required to suit your application.

```php
<?php
// src/AppBundle/Entity/CalendarEvent.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\CalendarBundle\Model\PersistedEvent as BaseCalendarEvent;

/**
 * A calendar event entity to contain the event information
 *
 * @ORM\Entity
 */
class CalendarEvent extends BaseCalendarEvent{

    // Extend the calendar event with additional application specific code...

    public function __construct()
    {        
        parent::__construct();
        //...
    }
}
```

### CalendarInvitee entity

The entity contains information about an event invitee, such as:
- The email address of the invitee.
- The invitation status

The invitee should be modified to include a reference to your user entity if
you have one.

The entity should extend the mapped superclass. You can provide any additional
entity code as required to suit your application.

```php
<?php
// src/AppBundle/Entity/CalendarInvitee.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\CalendarBundle\Model\Invitee as BaseCalendarInvitee;

/**
 * A invitee entity to contain the invited user information and status.
 *
 * @ORM\Entity
 */
class CalendarInvitee extends BaseCalendarInvitee{

    // Extend the calendar invitee with additional application specific code...

    public function __construct()
    {        
        parent::__construct();
        //...
    }
}
```

### CalendarComent entity

The entity contains any comments or messages made about an event:
- The email address of the invitee who commented.
- The message

The entity should extend the mapped superclass. You can provide any additional
entity code as required to suit your application.

```php
<?php
// src/AppBundle/Entity/CalendarComment.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\CalendarBundle\Model\EventComment as BaseCalendarComment;

/**
 * A invitee entity to contain the invited user information and status.
 *
 * @ORM\Entity
 */
class CalendarComment extends BaseCalendarComment{

    // Extend the calendar comments with additional application specific code...

    public function __construct()
    {        
        parent::__construct();
        //...
    }
}
```

## Step 3: Create listeners

The CalendarEventListener provides the mechanism to intercept the loading
of a calendar and modify the event entities before they are rendered.


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
        invitee_class:  AppBundle\Entity\CalendarInvitee
        comment_class:  AppBundle\Entity\CalendarComment
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

## Step 5: Integrate into one of your twig templates

The bundle requires:
- Jquery
- Moment
- Bootstrap 
- DatePicker
- FullCalendar

A typical twig template extending a bundle base.html.twig and using Content Delivery
Networks to provide js and css would look like:

```twig
{# app/Resources/views/calendar/calendar.html.twig #}

{% extends 'base.html.twig' %}

{% block stylesheets %}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('bundles/specshapercalendar/css/fullcalendar.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.min.css" />
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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('bundles/specshapercalendar/js/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/specshapercalendar/js/fullcalendar-settings.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.min.js"></script>

    <script>
        Calendar.init({
            loader: "{{ url('calendar_loader') }}",
            update: "{{ url('calendar_updateevent', {'id' : 'PLACEHOLDER'} ) }}",
            updateDateTime: "{{ url('calendar_updatedatetime', {'id' : 'PLACEHOLDER'} ) }}"
        });
    </script>

{% endblock %}
```

## Step 6: Customise

Use the entities to customise the persisted information and integrate the calendars with your
application entities.

Apply security via the route firewalls, or for more granular security control use the event
listeners to manage access.

Overwrite the twig modal and calendar template in your own app\Resources\SpecShaperCalendarBundle
directory to change the modal displays.

Copy and modify the fullcalendar-settings.js file to provide custom javascript functionality.
Or simply extend your twig template javascript block.

