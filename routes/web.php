<?php

use App\Http\Controllers\TelegramNotificationController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/notification', function () {
    return Inertia::render('Notification');
})->name('notification');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/telegram/notification', [TelegramNotificationController::class, 'send'])->name('send-notification');
    Route::get('/telegram/temp-code', [TelegramNotificationController::class, 'create'])->name('telegram-temp-code');
    Route::delete('/telegram/notifications', [TelegramNotificationController::class, 'destroy'])->name('disable-telegram-notifications');
});

Route::post('/telegram/webhook/'.config('services.telegram-bot-api.webhook'), [TelegramNotificationController::class, 'store']);
