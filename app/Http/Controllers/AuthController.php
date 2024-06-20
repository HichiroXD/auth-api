<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Registro de administrador
     */
    public function registerAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:10',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole('admin');

        return response()->json(['message' => 'Admin registrado exitosamente']);
    }

    /**
     * Inicio de sesión de administrador
     */
    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Registro de pacientes
     */
    public function registerPatient(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:10',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole('paciente');

        return response()->json(['message' => 'Paciente registrado exitosamente']);
    }

    /**
     * Inicio de sesión de paciente
     */
    public function loginPatient(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function updateHealthStatus(Request $request, $id)
    {
        // Validar la entrada
        $validatedData = $request->validate([
            'health_status' => 'required|integer|min:0|max:100',
        ]);

        // Encontrar al usuario
        $user = User::findOrFail($id);

        // Actualizar el estado de salud bucal
        $user->health_status = $validatedData['health_status'];
        $user->save();

        return response()->json(['message' => 'Estado de salud bucal actualizado exitosamente']);
    }

    /**
     * Registro de doctores por el administrador
     */
    public function registerDoctor(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:10',
        ]);

        // Crear el usuario con rol de doctor
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole('dentista');

        // Retornar la respuesta
        return response()->json(['message' => 'Doctor registrado exitosamente']);
    }

    /**
     * Inicio de sesión de doctor
     */
    public function loginDoctor(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    /**
     * Crear nuevo token
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }
}
