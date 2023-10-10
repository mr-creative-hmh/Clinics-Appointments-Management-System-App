<?php

namespace App\Http\Resources\Management;

use App\Http\Resources\Users\DoctorResource;
use App\Http\Resources\Users\PatientResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $appointmentDate = Carbon::parse($this->appointment->appointment_date);

        return [
            "ID" => $this->id,
            "Doctor" => new DoctorResource($this->doctor),
            "Patient"=> New PatientResource($this->patient),
            "AppointmentDate" => $appointmentDate->toDateString(),
            "AppointmentTime" => $appointmentDate->toTimeString(),
            "AppointmentType" => $this->appointment->appointment_type,
            "ReasonForVisit" => $this->appointment->reason_for_visit,
            'MedicalCondition' => $this->medical_condition,
            'Diagnosis' => $this->diagnosis,
            'Prescription' => $this->prescription,
            'DateOfVisit' => $this->date_of_visit,
            'FollowUpDate' => $this->follow_up_date,
            'AdditionalNotes' => $this->additional_notes,
            'Active' => $this->active,
        ];
    }
}
