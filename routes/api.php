<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'pet',
], function () {
    Route::get('/', 'App\Http\Controllers\PetController@index');
    Route::get('/{id}', 'App\Http\Controllers\PetController@show');
    Route::post('/', 'App\Http\Controllers\PetController@store');
    Route::put('/{id}', 'App\Http\Controllers\PetController@update');
    Route::delete('/{id}', 'App\Http\Controllers\PetController@delete');
});

Route::group([
    'prefix' => 'appointment',
], function() {
    Route::post('/{id}', 'App\Http\Controllers\AppointmentController@store');
});
