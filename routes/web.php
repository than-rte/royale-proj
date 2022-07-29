<?php

use App\Http\Controllers\Verms\VenueDetailController;
use App\Http\Controllers\Verms\VenueMediaController;
use App\Http\Controllers\Verms\DashboardController;
use App\Http\Controllers\Verms\EventController;
use App\Http\Controllers\Verms\MediaController;
use App\Http\Controllers\Verms\ScheduleController;
use App\Http\Controllers\Verms\VenueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return inertia('Index');
});

Route::prefix("verms")->group(function() {
    Route::prefix("dashboard")->group(function() {
        Route::get("/", [DashboardController::class, "index"])->name("verms.dashboard.index");
    });

    Route::prefix("schedules")->group(function() {
        Route::get("/", [ScheduleController::class, "index"])->name("verms.schedules.index");
    });
    
    Route::prefix("venues")->group(function() {
        Route::get("/", [VenueController::class, "index"])->name("verms.venues.index");
        Route::post("/", [VenueController::class, "store"])->name("verms.venues.store");
        Route::get("/edit/{venue}/details", [VenueDetailController::class, "index"])->name("verms.venues.details.index");
        Route::patch("/edit/{venue}/details", [VenueDetailController::class, "update"])->name("verms.venues.details.update");
        Route::get("/edit/{venue}/media", [VenueMediaController::class, "index"])->name("verms.venues.media.index");
        Route::post("/edit/{venue}/media", [VenueMediaController::class, "upload"])->name("verms.venues.media.upload");
    });

    Route::prefix("events")->group(function() {
        Route::get("/", [EventController::class, "index"])->name("verms.events.index");
    });

    Route::prefix("media")->group(function() {
        Route::get("/", [MediaController::class, "index"])->name("verms.media.index");
    });
});
