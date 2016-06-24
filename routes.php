<?php

/**
 * Your package routes would go here
 */

Route::get('/messages/all', function () {
    return json_encode('All Messages');
});

Route::group(['prefix' => 'notifications'], function() {
	
    Route::get('/', 'Infinety\Notifications\Controllers\NotificationsController@index');
    Route::get('/getNotifications', 'Infinety\Notifications\Controllers\NotificationsController@getNotifications');

    Route::get('/view/{id}', 'Infinety\Notifications\Controllers\NotificationsController@getview');
    Route::get('getNotifications/{id}', 'Infinety\Notifications\Controllers\NotificationsController@getNotificationsView');

    Route::get('/create', 'Infinety\Notifications\Controllers\NotificationsController@create');
    Route::post('/', 'Infinety\Notifications\Controllers\NotificationsController@store');


    //destroy
    Route::delete('/destroy/{id}', 'Infinety\Notifications\Controllers\NotificationsController@destroy');
    Route::delete('/view/destroy/{id}', 'Infinety\Notifications\Controllers\NotificationsController@destroySingle');
});

