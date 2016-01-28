SpecShaperCalendarBundle
=============

The SpecShaperCalendarBundle provides a calendar and appointment package for the Symfony2 system.

Features include:

- Written for Symfony verison 3.0.x
- Calendar entities can be stored via Doctrine ORM
- Entities are mapped superclasses to allow the AppBundle to add additional relationships.
- Events are generated to permit listener classes to intercept entities.
- FullCalendar.js front end
- Create, update and resize events from the calendar via ajax.

Features to be added:

- Support for MongoDB/CouchDB ODM or Propel
- Unit tests to be added
- Translation files


[![Build Status](https://travis-ci.org/FriendsOfSymfony/FOSUserBundle.svg?branch=master)](https://travis-ci.org/FriendsOfSymfony/FOSUserBundle) [![Total Downloads](https://poser.pugx.org/friendsofsymfony/user-bundle/downloads.svg)](https://packagist.org/packages/friendsofsymfony/user-bundle) [![Latest Stable Version](https://poser.pugx.org/friendsofsymfony/user-bundle/v/stable.svg)](https://packagist.org/packages/friendsofsymfony/user-bundle)

Documentation
-------------

The source of the documentation is stored in the `Resources/doc/` folder
in this bundle.

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

About
-----

CalendarBundle is a [SpecShaper](http://about.specshaper.com) bundle for managing project
appointments.

It is based on the [adesigns/calendar-bundle](https://github.com/adesigns/calendar-bundle) modified
and extended with additional functionality.


Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/mogilvie/CalendarBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require <package-name> "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

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

            new <vendor>\<bundle-name>\<bundle-long-name>(),
        );

        // ...
    }

    // ...
}