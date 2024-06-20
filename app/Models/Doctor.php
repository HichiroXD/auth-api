<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_id',
        'experience',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function createSchedule($day, $start_time, $end_time)
    {
        return Schedule::create([
            'doctor_id' => $this->id,
            'day' => $day,
            'start_time' => $start_time,
            'end_time' => $end_time,
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

    public function rescheduleAppointment($appointmentId, $newDate, $newTime)
    {
        $appointment = $this->appointments()->where('id', $appointmentId)->first();
        if ($appointment) {
            $appointment->update([
                'date' => $newDate,
                'time' => $newTime,
            ]);
            return true;
        }
        return false;
    }
}
