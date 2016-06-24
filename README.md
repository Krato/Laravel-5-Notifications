# Laravel 5 Notifications

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![StyleCI][ico-styleci]][link-styleci]

## A package to manage Notifications

With this package you can send notifications to your model. You can choose if you want users, or whatever model.

Notifications are saved on `notifications` and each item of your model can retrieve it. Also you can set each notification as read.


## Installation

**Install via composer**: `composer require infinety-es\notifications`

Then register the service provider in `config/app.php` inside `providers` array:
```php
Infinety\Notifications\NotificationsServiceProvider::class,
```

**Publish package files**:

```php
php artisan vendor:publish --provider="Infinety\Notifications\NotificationsServiceProvider"
```

> **Tip:** You can also publish only this tags: `config`, `views` and `migrations`


After modify `config\notifications.php` file `NotificationTrait`to your model. For example User model: 

```php
<?php
namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Infinety\Notifications\Traits\NotificationTrait;

class User extends Authenticatable
{

    use NotificationTrait;
```

## Use

In your browser go to `notifications`. Example: `www.infinety.app/notifications`.

Default pages are in `resources\views\vendor\notifications`. You can `view` and `create` notifications with a simple interface. You can modify everything.

## Command

You can create notifications by `artisan` with command:
```bash
php artisan notifications:new
```

You have some options you need to add. If not, the command will ask you. Options are:
```bash
--notify[=NOTIFY]    A model ID, or all
--subject[=SUBJECT]  Notification subject
--message[=MESSAGE]  Notification message
--type[=TYPE]        Type of notifications defined in config file
```

## Trait Methods

### Get all notifications
```php
    /**
     * Get All Notifications. Readed or not
     *
     * @return Eloquent
     */
    public function notifications()
```
This method retrieves all notifications read and not read notifications


### Get not read notifications
```php
    /**
     * Get not read notifications
     *
     * @return Eloquent
     */
     public function getNotReadNotifications()
```
This method retrieves not read notifications

### Get read notifications
```php
    /**
     * Get read Notifications
     *
     * @return Eloquent
     */
    public function getReadNotifications()
```
This method retrieves read notifications. It's great if you want to show history.

### Get count of all notifications
```php
    /**
     * Get Count of all Notifications
     *
     * @return integer
     */
    public function getAllNotificationCount()
```
Get count of all notifications including read and not read.

### Get count of not read notifications
```php
    /**
     * Get Count of not read Notifications
     *
     * @return integer
     */
    public function getNotReadNotificationCount()
```
Get count of all notifications not read.

## Contributing
All contributions (in the form on pull requests, issues and feature-requests) are
welcome. See the [contributors page](../../graphs/contributors) for all contributors.

##License

Laravel 5 Notifications is an open-sourced laravel package licensed under the MIT License (MIT).
Please see the [license file](LICENSE.md) for more information.


[ico-version]: https://img.shields.io/packagist/v/infinety-es/notifications.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/infinety-es/notifications.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/60768133/shield

[link-packagist]: https://packagist.org/packages/infinety-es/notifications
[link-downloads]: https://packagist.org/packages/infinety-es/notifications
[link-styleci]: https://styleci.io/repos/60768133
