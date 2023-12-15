<?php

use App\Http\Controllers\HealthHandler;
use App\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;

// Health Check
Route::get('/health', [HealthHandler::class, "health"]);
Route::get('/liveness', [HealthHandler::class, "liveness"]);

// Documentation routes
Route::group(["prefix" => "documentation"], function () {
    Route::get("/", [DocumentationController::class, "show"]);
    Route::get("/v1.yaml", [DocumentationController::class, "yaml"]);
    Route::get("/v2.yaml", [DocumentationController::class, "yamlV2"]);
});

Route::group(["prefix" => '/api/v1'], function () {
    Route::group(["prefix" => '/customer'], function () {
        Route::get('/', [CustomerController::class, 'getCustomerPanel']);
        Route::get('/show', [CustomerController::class, 'showCustomer']);
        Route::post('/create', [CustomerController::class, 'createCustomer']);
        Route::patch('/update', [CustomerController::class, 'updateCustomer']);
        Route::delete('/delete', [CustomerController::class, 'deleteCustomer']);
    });
});
