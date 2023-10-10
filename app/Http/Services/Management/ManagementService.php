<?php

namespace App\Http\Services\Management;

use App\Models\Management\Appointment;
use App\Models\Management\DoctorSchedule;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; // Import QueryException for database errors

class ManagementService
{
    // DoctorSchedule Section

    // Create DoctorSchedule
    public static function createSchedules($doctor_id,$clinic_id,$day_of_week,$start_time,$end_time,$appointment_duration)
    {

        // Cast start_time and end_time to a time format
        $start_time = Carbon::parse($start_time)->format('H:i:s');
        $end_time = Carbon::parse($end_time)->format('H:i:s');

        // Check if a schedule with the same data already exists
        $existingSchedules = DoctorSchedule::where('doctor_id', $doctor_id)
            ->where('clinic_id', $clinic_id)
            ->where('day_of_week', $day_of_week)
            ->get();

        foreach ($existingSchedules as $schedule) {

            //Exisit one

            if ($start_time == $schedule->start_time && $end_time == $schedule->end_time) {
                // Prevent creation due to exact match
                return ['status' => 'exists', 'schedule' => $schedule];
            }
            // Check if the new schedule's start and end times conflict with any existing schedule
            if (
                // Case 1: New schedule starts before an existing schedule and ends during it
                ($start_time <= $schedule->start_time && $end_time >= $schedule->start_time && $end_time <= $schedule->end_time) ||

                // Case 2: New schedule starts during an existing schedule and ends after it
                ($start_time >= $schedule->start_time && $start_time <= $schedule->end_time && $end_time >= $schedule->end_time) ||

                // Case 3: New schedule starts and ends within an existing schedule
                ($start_time >= $schedule->start_time && $end_time <= $schedule->end_time) ||

                // Case 4: New schedule completely overlaps an existing schedule
                ($start_time <= $schedule->start_time && $end_time >= $schedule->end_time)
            ) {
                // Prevent creation due to conflicts
                return ['status' => 'conflict', 'schedule' => $schedule];
            }
        }

        // If no existing schedule is found, create a new one
        $created_schedule = DoctorSchedule::create([
            "doctor_id" => $doctor_id,
            "clinic_id" => $clinic_id,
            "day_of_week" => $day_of_week,
            "start_time" => $start_time,
            "end_time" => $end_time,
            "appointment_duration" => $appointment_duration,
        ]);

        return ['status' => 'created', 'schedule' => $created_schedule];
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
    public static function deleteSchedule(DoctorSchedule $doctorschedule)
    {
        // Delete the doctor schedule
        $doctorschedule->delete();

    }


    // Appointment Section


    //Get Schedule by DateTime
    public function getDoctorScheduleByDatetime($doctorId, $datetime)
    {
        // Parse the input datetime to a Carbon instance for comparison
        $inputDatetime = Carbon::parse($datetime);

        // Find the day of the week for the input datetime
        $dayOfWeek = $inputDatetime->format('l');

        // Find the doctor's schedule that matches the input datetime
        return DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->whereTime('start_time', '<=', $inputDatetime->format('H:i:s'))
            ->whereTime('end_time', '>=', $inputDatetime->format('H:i:s'))
            ->first();
    }

    // Create Appointment
    public static function createAppointment($doctor_schedule_id,$patient_id,$appointment_date,$appointment_type,$appointment_status,$reason_for_visit)
    {

        // Retrieve the doctor schedule for the given $doctor_schedule_id
        $doctorSchedule = DoctorSchedule::find($doctor_schedule_id);

        // Check if there is an existing appointment for the same doctor_schedule_id and appointment_date
        $existingAppointment = Appointment::where('doctor_schedule_id', $doctor_schedule_id)
            ->where('appointment_date', $appointment_date)
            ->first();

        if ($existingAppointment) {
            // Handle the case where an appointment already exists
            return ['status' => 'exists', 'appointment' => $existingAppointment];
        }
        $carbonDate = Carbon::parse($appointment_date);
        $appointment_day = $carbonDate->format('l');

        // Check if the day of the appointment_date matches the doctor's schedule day_of_week
        if ($appointment_day !== $doctorSchedule->day_of_week) {
            // Handle the case where the appointment date's day doesn't match the doctor's schedule
            return ['status' => 'invalid_day', 'message' => 'Appointment day does not match the doctor\'s schedule.'];
        }

        // If no existing appointment is found, create a new appointment
        $createdAppointment = Appointment::create([
            "doctor_schedule_id" => $doctor_schedule_id,
            "patient_id" => $patient_id,
            "appointment_date" => $appointment_date,
            "appointment_type" => $appointment_type,
            "appointment_status" => $appointment_status,
            "reason_for_visit" => $reason_for_visit,
        ]);

        return ['status' => 'created', 'appointment' => $createdAppointment];
    }


    public static function getAvailableAppointments($doctorSchedule, $date)
    {
        // Step 1: Extract necessary data from the doctor's schedule
        $startDateTime = Carbon::parse($date)->setTimeFromTimeString($doctorSchedule->start_time);
        $endDateTime = Carbon::parse($date)->setTimeFromTimeString($doctorSchedule->end_time);
        $appointmentDuration = $doctorSchedule->appointment_duration;

        // Step 2: Generate time slots based on the extracted data
        $timeSlots = [];
        $currentTime = clone $startDateTime;

        while ($currentTime->addMinutes($appointmentDuration)->lte($endDateTime)) {
            $timeSlots[] = $currentTime->copy()->format('Y-m-d H:i:s');
        }

        // Step 3: Query the appointments table for existing appointments on the specific date
        $existingAppointments = Appointment::where('doctor_schedule_id', $doctorSchedule->id)
            ->whereDate('appointment_date', $date)
            ->pluck('appointment_date')
            ->toArray();

        // Step 4: Exclude the scheduled time slots
        $availableSlots = array_diff($timeSlots, $existingAppointments);

        // Step 5: Return the available time slots
        return $availableSlots;
    }

    //Update Appointment
    public static function updateAppointment(Appointment $appointment, Request $request)
    {
        $appointmentData = $request->validated();

        // Update the Appointment data
        $appointment->update($appointmentData);

        return $appointment;
    }



    //Delete Appointment
    public static function deleteAppointment(Appointment $Appointment)
    {
        // Delete the Appointment
        $Appointment->delete();

    }
}
