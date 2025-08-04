<?php


use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::middleware([\App\Http\Middleware\CheckApiKey::class])->group(function () {
    // Организации в здании
    Route::get('/buildings/{building}/organizations', [BuildingController::class, 'organizations']);

    // Организации по деятельности
    Route::get('/activities/{activity}/organizations', [ActivityController::class, 'byActivity']);

    // Поиск по радиусу
    Route::get('/organizations/nearby', [OrganizationController::class, 'nearby']);

    // Информация об организации
    Route::get('/organizations/{organization}', [OrganizationController::class, 'show']);

    // Поиск по названию деятельности
    Route::get('/search/activities', [ActivityController::class, 'search']);

    // Поиск по названию организации
    Route::get('/organizations', [OrganizationController::class, 'searchByName']);
});
