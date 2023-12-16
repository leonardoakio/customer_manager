<?php

use App\Infrastructure\Controllers\AuthController;
use App\Infrastructure\Controllers\CustomerController;
use App\Infrastructure\Controllers\HealthHandler;
use App\Infrastructure\Controllers\DocumentationController;
use App\Infrastructure\Controllers\PostalCodeController;
use Illuminate\Support\Facades\Route;

// Health Check
Route::get("/health", [HealthHandler::class, "health"]);
Route::get("/liveness", [HealthHandler::class, "liveness"]);

// Documentation routes
Route::group(["prefix" => "documentation"], function () {
    Route::get("/", [DocumentationController::class, "show"]);
    Route::get("/v1.yaml", [DocumentationController::class, "yaml"]);
    Route::get("/v2.yaml", [DocumentationController::class, "yamlV2"]);
});

Route::group(["prefix" => "/auth"], function () {
    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::post('/refresh', [AuthController::class, "refresh"]);
});

Route::group(["prefix" => "/api/v1", 'middleware' => 'jwt'], function () {
    Route::group(["prefix" => "/customer"], function () {
        Route::get("/", [CustomerController::class, "getCustomerPanel"]);
        Route::get("/{id}", [CustomerController::class, "showCustomer"]);
        Route::post("/{id}", [CustomerController::class, "createCustomer"]);
        Route::patch("/{id}", [CustomerController::class, "updateCustomer"]);
        Route::delete("/{id}", [CustomerController::class, "deleteCustomer"]);
    });

    Route::get("/buscar/{cep}", [PostalCodeController::class, "searchPostalCode"]);
});
