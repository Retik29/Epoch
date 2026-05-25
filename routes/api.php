<?php

use App\Http\Controllers\Api\AppointmentApiController;
use App\Http\Controllers\Api\ProfessionalApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Epoch
|--------------------------------------------------------------------------
*/

// Public API routes
Route::get('/professionals', [ProfessionalApiController::class, 'index']);
Route::get('/professionals/{professional}', [ProfessionalApiController::class, 'show'])
    ->where('professional', '[a-fA-F0-9]{24}');

// Authenticated API routes (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => response()->json($request->user()));

    Route::apiResource('appointments', AppointmentApiController::class)
        ->names([
            'index'   => 'api.appointments.index',
            'store'   => 'api.appointments.store',
            'show'    => 'api.appointments.show',
            'update'  => 'api.appointments.update',
            'destroy' => 'api.appointments.destroy',
        ]);
});

// Health check
Route::get('/ping', fn() => response()->json(['status' => 'ok', 'service' => 'Epoch API', 'version' => '1.0']));
