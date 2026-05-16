<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InferenceController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
});

Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::get('/plans', [PlanController::class, 'index']);
    Route::get('/plans/{plan}', [PlanController::class, 'show']);

    Route::middleware('can:manage-plans')->group(function () {
        Route::post('/plans', [PlanController::class, 'store']);
        Route::put('/plans/{plan}', [PlanController::class, 'update']);
        Route::delete('/plans/{plan}', [PlanController::class, 'destroy']);
    });

    Route::get('/subscriptions/current', [SubscriptionController::class, 'current']);
    Route::post('/subscriptions', [SubscriptionController::class, 'subscribe']);
    Route::get('/inference/history', [InferenceController::class, 'history']);
    Route::get('/inference/stats', [InferenceController::class, 'stats'])->middleware('can:viewAny,App\\Models\\InferenceRecord');
});

Route::middleware(['web', 'throttle:30,1'])->post('/inference/predict', [InferenceController::class, 'predict']);
