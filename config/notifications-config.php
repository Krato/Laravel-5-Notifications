<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model to send notifications
    |--------------------------------------------------------------------------
    |
     */
    'model' => App\User::class,

    /*
    |--------------------------------------------------------------------------
    | Model column to show
    |--------------------------------------------------------------------------
    |
     */
    'model_column' => 'name',


    /*
    |--------------------------------------------------------------------------
    | Model column to make the relation
    |--------------------------------------------------------------------------
    |
     */
    'model_field' => 'id',


    /*
    |--------------------------------------------------------------------------
    | Model to send notifications. Sorry in beta
    |--------------------------------------------------------------------------
    |
     */
    'group_model' => Infinety\Notifications\Models\GroupNotification::class,


    /*
    |--------------------------------------------------------------------------
    | Model column to make the relation. . Sorry in beta
    |--------------------------------------------------------------------------
    |
     */
    'group_field' => 'id',

    /*
    |--------------------------------------------------------------------------
    | List of notification types. Please not null
    |
    | First is the type. Example: critical
    | Second is the label class for labels. Example: label-danger
    |--------------------------------------------------------------------------
    |
     */
    'notification_types' => [
        'info'     => 'label-info',
        'success'  => 'label-success',
        'warning'  => 'label-warning',
        'critical' => 'label-danger',
    ],
];
