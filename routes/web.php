<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ChatController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LegalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Páginas legales — acceso público
Route::get('/privacidad',    [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/datos',         [LegalController::class, 'dataUsage'])->name('legal.data-usage');
Route::get('/cookies',       [LegalController::class, 'cookies'])->name('legal.cookies');
Route::get('/terminos',      [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/consentimiento',[LegalController::class, 'consent'])->name('legal.consent');

// Planes
Route::get('/planes/full',  [HomeController::class, 'fullPlan'])->name('plans.full');
Route::post('/planes/full', [HomeController::class, 'fullPlanSubmit'])->name('plans.full.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/chat',      [ChatController::class, 'index'])->name('chat');
    Route::post('/chat/send',[ChatController::class, 'send'])->name('chat.send');
    Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',             [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users/{user}', [AdminController::class, 'userDetail'])->name('user');
});
