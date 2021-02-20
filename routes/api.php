<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'pet',
], function () {
    Route::get('/', 'PetController@index');
    Route::get('/{pet}', 'PetController@show');
    Route::post('/', 'PetController@store');
    Route::put('/{pet}', 'PetController@update');
    Route::delete('/{pet}', 'PetController@delete');
});

Route::group([
    'prefix' => 'appointment',
], function() {
    Route::post('/{pet}', 'AppointmentController@store');
});
