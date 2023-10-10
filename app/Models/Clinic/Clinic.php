<?php

namespace App\Models\Clinic;

use App\Models\Management\DoctorSchedule;
use App\Models\User\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'operating_hours',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class , 'clinic_doctors' , 'clinic_id', 'doctor_id');
    }

    public function doctorschedules()
    {
        return $this->belongsToMany(DoctorSchedule::class);
    }
}
