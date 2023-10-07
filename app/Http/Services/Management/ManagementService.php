<?php

namespace App\Http\Services\Management;

use App\Models\Management\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; // Import QueryException for database errors

class ManagementService
{
    // DoctorSchedule Section

    // Create DoctorSchedule
    public static function createSchedules($doctor_id,$clinic_id,$day_of_week,$start_time,$end_time)
    {
        // Check if a schedule with the same data already exists
        $existingSchedule = DoctorSchedule::where('doctor_id', $doctor_id)
            ->where('clinic_id', $clinic_id)
            ->where('day_of_week', $day_of_week)
            ->where('start_time', $start_time)
            ->where('end_time', $end_time)
            ->first();

        // If an existing schedule is found, return it
        if ($existingSchedule) {
            return ['status' => 'exists', 'schedule' => $existingSchedule];
        }

        // If no existing schedule is found, create a new one
        $created_schedule = DoctorSchedule::create([
            "doctor_id" => $doctor_id,
            "clinic_id" => $clinic_id,
            "day_of_week" => $day_of_week,
            "start_time" => $start_time,
            "end_time" => $end_time
        ]);

        return $created_schedule;
    }

    //Update DoctorSchedule
    public static function updateSchedule(DoctorSchedule $doctorschedule, Request $request)
    {
        $doctorscheduleData = $request->validated();

        // Update the doctor schedule's data
        $doctorschedule->update($doctorscheduleData);

        return $doctorschedule;
    }



    //Delete DoctorSchedule
    public static function deleteSchedules(DoctorSchedule $doctorschedule)
    {
        // Delete the doctor schedule
        $doctorschedule->delete();

    }

}
