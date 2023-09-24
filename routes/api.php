<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\PersonalController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Users

    Route::get("/users", [UserController::class, "getAll"]);
    Route::get("/user/{id}", [UserController::class, "getById"]);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::put('/users/active/{id}', [UserController::class, 'updateActive']);

    // Personal Code

    Route::get("/personal", [PersonalController::class, "getAll"]);
    Route::get("/personal/{id}", [PersonalController::class, "getById"]);
    Route::post("/personal", [PersonalController::class, "create"]);
    Route::put('/personal/{id}', [PersonalController::class, 'update']);
    Route::delete('/personal/{id}', [PersonalController::class, 'delete']);
    Route::put('/personal/active/{id}', [PersonalController::class, 'updateActive']);

    // Training

    Route::get("/workouts", [TrainingController::class, "getAll"]);
    Route::get("/training/{id}", [TrainingController::class, "getById"]);
    Route::post("/training", [TrainingController::class, "create"]);
    Route::put('/training/{id}', [TrainingController::class, 'update']);
    Route::delete('/training/{id}', [TrainingController::class, 'delete']);
    Route::put('/training/active/{id}', [TrainingController::class, 'updateActive']);

    // Logout

    Route::post('/logout', [AuthController::class, 'logout']);
});

// Login

Route::post('/login', [AuthController::class, 'login']);

// Create User

Route::post("/user", [UserController::class, "create"]);