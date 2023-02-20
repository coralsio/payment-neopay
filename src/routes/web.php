<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'neopay'], function () {
    Route::match(['get', 'post'], 'client-redirect', 'NeopayController@clientRedirect');
});
