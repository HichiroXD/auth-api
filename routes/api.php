<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrescriptionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta para obtener el usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de autenticación
Route::post('register-admin', [AuthController::class, 'registerAdmin'])->name('register-admin'); // Ruta para registrar administradores
Route::post('login-admin', [AuthController::class, 'loginAdmin'])->name('login-admin'); // Ruta para iniciar sesión como administrador
Route::post('register-team-member', [AuthController::class, 'registerTeamMember'])->name('register-team-member'); // Ruta para registrar miembros del equipo
Route::post('login-team-member', [AuthController::class, 'loginTeamMember'])->name('login-team-member'); // Ruta para iniciar sesión como miembro del equipo
Route::post('login-project-manager', [AuthController::class, 'loginProjectManager'])->name('login-project-manager'); // Ruta para iniciar sesión como jefe de proyecto
Route::post('logout', [AuthController::class, 'logout'])->name('logout'); // Ruta para cerrar sesión

// Registro de jefes de proyecto (antes médicos) solo por administradores
Route::post('register-project-manager', [AuthController::class, 'registerProjectManager'])->middleware(['auth:sanctum', 'role:admin'])->name('register-project-manager');

// Rutas para la gestión de proyectos y requerimientos
Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas para administradores
    Route::middleware('role:admin')->group(function () {
        // Rutas específicas para administradores
    });

    // Rutas para jefes de proyecto (antes médicos)
    Route::middleware('role:project-manager')->group(function () {
        // Rutas específicas para jefes de proyecto
    });

    // Rutas para miembros del equipo (antes pacientes)
    Route::middleware('role:team-member')->group(function () {
        // Rutas específicas para miembros del equipo
    });
});
