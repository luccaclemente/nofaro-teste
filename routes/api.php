<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'pet',
], function () {
    Route::get('/', 'App\Http\Controllers\PetController@index');
    Route::get('/{pet}', 'App\Http\Controllers\PetController@show');
    Route::post('/', 'App\Http\Controllers\PetController@store');
    Route::put('/{pet}', 'App\Http\Controllers\PetController@update');
    Route::delete('/{pet}', 'App\Http\Controllers\PetController@delete');
});

Route::group([
    'prefix' => 'appointment',
], function() {
    Route::post('/{pet}', 'App\Http\Controllers\AppointmentController@store');
});
