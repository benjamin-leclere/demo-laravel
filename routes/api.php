<?php

use App\Http\Controllers\GeoController;
use App\Http\Controllers\HolidaysController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('geo')->group(function () {

    Route::get('/cities/{postcode}', [
        GeoController::class,
        'getCitiesFromPostcode'
    ]);

});

Route::prefix('holidays')->group(function () {

    Route::get('/', [
        HolidaysController::class,
        'getHolidays'
    ]);

    Route::get('/countries', [
        HolidaysController::class,
        'getSupportedCountries'
    ]);

    Route::get('/languages', [
        HolidaysController::class,
        'getSupportedLanguages'
    ]);

});
