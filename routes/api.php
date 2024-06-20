<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AppointmentController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de autenticación
Route::post('r-Admin', [AuthController::class, 'registerAdmin']); 
Route::post('l-Admin', [AuthController::class, 'loginAdmin']);

Route::post('r-Patient', [AuthController::class, 'registerPatient']);
Route::post('l-Patient', [AuthController::class, 'loginPatient']);

Route::post('r-Doctor', [AuthController::class, 'registerDoctor']);
Route::post('l-Doctor', [AuthController::class, 'loginDoctor']);

Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    Route::post('prescriptions', [PrescriptionController::class, 'store'])->middleware('permission:create_prescription'); // Crear receta
    Route::put('prescriptions/{id}', [PrescriptionController::class, 'update'])->middleware('permission:edit_prescription'); // Actualizar receta
    Route::get('prescriptions/{id}', [PrescriptionController::class, 'show'])->middleware('permission:view_prescription'); // Ver receta
    Route::delete('prescriptions/{id}', [PrescriptionController::class, 'destroy'])->middleware('permission:delete_prescription'); // Eliminar receta

    Route::post('appointments', [AppointmentController::class, 'store'])->middleware('permission:register_appointment'); // Crear cita
    Route::put('appointments/{id}', [AppointmentController::class, 'update'])->middleware('permission:edit_appointment'); // Actualizar cita
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->middleware('permission:delete_appointment'); // Cancelar cita
    Route::get('appointments/{id}', [AppointmentController::class, 'show'])->middleware('permission:list_appointment'); // Ver cita
});

Route::middleware(['auth:api', 'role:dentista'])->group(function () {
    Route::put('users/{id}/health-status', [AuthController::class, 'updateHealthStatus']);
});