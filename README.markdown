SpecShaperCalendarBundle
=============

The SpecShaperCalendarBundle adds support for a database-backed user system in Symfony2.
It provides a flexible framework for user management that aims to handle
common tasks such as user registration and password retrieval.

Features include:

- Users can be stored via Doctrine ORM, MongoDB/CouchDB ODM or Propel
- Registration support, with an optional confirmation per email
- Password reset support
- Unit tested

**Note:** This bundle does *not* provide an authentication system but can
provide the user provider for the core [SecurityBundle](https://symfony.com/doc/current/book/security.html).

**Caution:** This bundle is developed in sync with [symfony's repository](https://github.com/symfony/symfony).
For Symfony 2.0.x, you need to use the 1.2.0 release of the bundle (or lower)

[![Build Status](https://travis-ci.org/FriendsOfSymfony/FOSUserBundle.svg?branch=master)](https://travis-ci.org/FriendsOfSymfony/FOSUserBundle) [![Total Downloads](https://poser.pugx.org/friendsofsymfony/user-bundle/downloads.svg)](https://packagist.org/packages/friendsofsymfony/user-bundle) [![Latest Stable Version](https://poser.pugx.org/friendsofsymfony/user-bundle/v/stable.svg)](https://packagist.org/packages/friendsofsymfony/user-bundle)

Documentation
-------------

The source of the documentation is stored in the `Resources/doc/` folder
in this bundle, and available on symfony.com:

[Read the Documentation for master](https://symfony.com/doc/master/bundles/FOSUserBundle/index.html)

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

About
-----

CalendarBundle is a [knplabs](https://github.com/knplabs) initiative.
See also the list of [contributors](https://github.com/FriendsOfSymfony/FOSUserBundle/contributors).

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/FriendsOfSymfony/FOSUserBundle/issues).

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