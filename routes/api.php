<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('r-admin', [AuthController::class, 'registerAdmin']);
Route::post('l-admin', [AuthController::class, 'loginAdmin']);
Route::post('register', [AuthController::class, 'registerPatient']);
Route::post('login-patient', [AuthController::class, 'loginPatient']);
Route::post('login-dentist', [AuthController::class, 'loginDoctor']);
Route::post('logout', [AuthController::class, 'logout']);

Route::post('register-doctor', [AuthController::class, 'registerDoctor'])->middleware('auth:api');
