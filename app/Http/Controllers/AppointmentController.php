<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $patient = Auth::user()->patient;

        $appointment = $patient->requestAppointment($request->doctor_id, $request->date, $request->time);

        return response()->json(['message' => 'Cita solicitada exitosamente', 'appointment' => $appointment], 201);
    }

    public function destroy($id)
    {
        $patient = Auth::user()->patient;
        if ($patient->cancelAppointment($id)) {
            return response()->json(['message' => 'Cita cancelada exitosamente'], 200);
        }
        return response()->json(['error' => 'No autorizado o cita no encontrada'], 403);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $doctor = Auth::user()->doctor;
        if ($doctor->rescheduleAppointment($id, $request->date, $request->time)) {
            return response()->json(['message' => 'Cita reprogramada exitosamente'], 200);
        }
        return response()->json(['error' => 'No autorizado o cita no encontrada'], 403);
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        if (Auth::user()->id !== $appointment->patient_id && Auth::user()->id !== $appointment->doctor_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        return response()->json(['appointment' => $appointment], 200);
    }
}
