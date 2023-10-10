<?php

namespace App\Models\Management;

use App\Models\User\Doctor;
use App\Models\User\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_id',
        'medical_condition',
        'diagnosis',
        'prescription',
        'date_of_visit',
        'follow_up_date',
        'additional_notes',
        'active',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

}
