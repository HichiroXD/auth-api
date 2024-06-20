<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'gender',
        'dental_problem',
        'document_number',
    ];

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set('America/Santiago');
        $this->attributes['created_at'] = Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set('America/Santiago');
        $this->attributes['updated_at'] = Carbon::now();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function requestAppointment($doctorId, $date, $time)
    {
        return Appointment::create([
            'patient_id' => $this->id,
            'doctor_id' => $doctorId,
            'date' => $date,
            'time' => $time,
            'status' => 'scheduled',
        ]);
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = $this->appointments()->where('id', $appointmentId)->first();
        if ($appointment) {
            $appointment->delete();
            return true;
        }
        return false;
    }
}
