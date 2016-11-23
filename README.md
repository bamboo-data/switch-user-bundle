BambooSwitchUserBundle
======================

[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://img.shields.io/badge/License-GPL%20v2-blue.svg)

## Summary

User switching for eZ Publish 5.4 / eZ Platform 6.x.

## Copyright

Copyright (C) 2016 [Bamboo Data Ltd](http://www.bamboo-data.co.uk)

## License

Licensed under [GNU General Public License 2.0](http://www.gnu.org/licenses/gpl-2.0.html)

## Requirements

Requires eZ Publish 5.4 or above.

## Installation

Install using composer:

    composer require bamboo/switch-user-bundle

Edit `app/EzPublishKernel.php` or `ezpublish/EzPublishKernel.php` and add the following
to the list of bundles in `registerBundles()`:

    new Bamboo\SwitchUserBundle\BambooSwitchUserBundle(),

Edit `app/config/routing.php` or `ezpublish/config/routing.php` and add the following:

    bamboo_switch_user:
        resource: "@BambooSwitchUserBundle/Resources/config/routing.yml"

## Configuration

By default, switching is allowed to any user not in the 'Administrator users' user group.
To change this configuration, add a block to `app/config/config.yml` or `ezpublish/config/config.yml`.
For example:

    bamboo_switch_user:
        groups:
            deny: []
            allow: [ 128 ]

This will only allow switching to users in user group with ID 128.

## Usage

Decide which roles will have the ability to switch user account and in the admin
interface add the `switchuser/manage` policy to them. If only the
'Administrator users' user group needs the ability then you can skip this step.

Users with this policy will be able to switch to any permitted user using the path:

    /switch-user/{username}

where `{username}` is the user's login or:

    /switch-user/id/{id}

where `{id}` is the ID of the user.
