<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProfessionalDashboardController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Epoch
|--------------------------------------------------------------------------
*/

// ─── Public Routes ───────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');
Route::get('/professionals/{professional}', [ProfessionalController::class, 'show'])
    ->where('professional', '[0-9]+')
    ->name('professionals.show');

// Locale switcher
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'hi'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('locale.switch');

// Contact routes
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// ─── Auth Routes ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Authenticated User Routes ────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // User dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])
        ->where('appointment', '[0-9]+')
        ->name('appointments.show');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->where('appointment', '[0-9]+')
        ->name('appointments.cancel');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->where('appointment', '[0-9]+')
        ->name('appointments.destroy');

    // ─── Payment Routes ──────────────────────────────────────────────────────
    Route::post('/payments/initiate',  [PaymentController::class, 'initiate'])->name('payments.initiate');
    Route::post('/payments/success',   [PaymentController::class, 'success'])->name('payments.success');
    Route::post('/payments/simulate',  [PaymentController::class, 'simulate'])->name('payments.simulate');
    Route::get('/payments/failed',     [PaymentController::class, 'failed'])->name('payments.failed');
});

// ─── Professional Routes ──────────────────────────────────────────────────────
Route::middleware(['auth', 'professional'])->prefix('professional')->name('professional.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ProfessionalDashboardController::class, 'index'])->name('dashboard');

    // Appointment management
    Route::patch('/appointments/{appointment}/confirm', [ProfessionalDashboardController::class, 'confirm'])
        ->where('appointment', '[0-9]+')
        ->name('appointments.confirm');
    Route::patch('/appointments/{appointment}/reject', [ProfessionalDashboardController::class, 'reject'])
        ->where('appointment', '[0-9]+')
        ->name('appointments.reject');
    Route::patch('/appointments/{appointment}/complete', [ProfessionalDashboardController::class, 'complete'])
        ->where('appointment', '[0-9]+')
        ->name('appointments.complete');

    // Profile management
    Route::get('/profile/create', [ProfessionalController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfessionalController::class, 'store'])->name('profile.store');
    Route::get('/profile/{professional}/edit', [ProfessionalController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{professional}', [ProfessionalController::class, 'update'])->name('profile.update');

    // Availability
    Route::post('/availability', [ProfessionalDashboardController::class, 'updateAvailability'])
        ->name('availability.update');
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/professionals', [AdminController::class, 'professionals'])->name('professionals');
    Route::patch('/professionals/{professional}/toggle', [AdminController::class, 'toggleProfessional'])->name('professionals.toggle');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
});
