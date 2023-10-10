<?php

namespace App\Models\User;

use App\Models\Common\User;
use App\Models\Management\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $with = ["user"];
    protected $fillable = [
        'user_id',
        'wight',
        'hight',
        'additional_info'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class , 'doctor_patients' , 'patient_id' , 'doctor_id');
    }

    public function medicalrecords()
    {
        return $this->belongsToMany(MedicalRecord::class);
    }
}
