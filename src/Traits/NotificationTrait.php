<?php

namespace Infinety\Notifications\Traits;

use Infinety\Notifications\Models\Notification;

trait NotificationTrait
{
    /**
     * Get All Notifications. Readed or not.
     *
     * @return Eloquent
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'model_id', config('notifications.model_field'))->orderBy('sent_at');
    }

    /**
     * Get not read notifications.
     *
     * @return Eloquent
     */
    public function getNotReadNotifications()
    {
        return $this->hasMany(Notification::class, 'model_id', config('notifications.model_field'))->where('is_read', 0)->orderBy('sent_at');
    }

    /**
     * Get read Notifications.
     *
     * @return Eloquent
     */
    public function getReadNotifications()
    {
        return $this->hasMany(Notification::class, 'model_id', config('notifications.model_field'))->where('is_read', 1)->orderBy('sent_at');
    }

    /**
     * Get Count of all Notifications.
     *
     * @return int
     */
    public function getAllNotificationCount()
    {
        return $this->hasMany(Notification::class, 'model_id', config('notifications.model_field'))->count();
    }

    /**
     * Get Count of not read Notifications.
     *
     * @return int
     */
    public function getNotReadNotificationCount()
    {
        return $this->hasMany(Notification::class, 'model_id', config('notifications.model_field'))->where('is_read', 0)->count();
    }
}
