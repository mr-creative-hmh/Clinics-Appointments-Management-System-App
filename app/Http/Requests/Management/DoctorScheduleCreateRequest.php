<?php

namespace App\Http\Requests\Management;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DoctorScheduleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'clinic_id' => 'required|exists:clinics,id',
            'day_of_week' => [
                'required',
                'string',
                'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            ],
            'start_time' => 'required|date_format:H:i',
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time', // Ensure end_time is after start_time
                //'after_or_equal:start_time(i+15)', // Ensure end_time is at least 15 minutes after start_time
            ],
            'appointment_duration' => 'required', //if( value > 0 && value % 15 == 0 )
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Doctor is required.',
            'doctor_id.exists' => 'Doctor not found.',
            'clinic_id.required' => 'Clinic is required.',
            'clinic_id.exists' => 'Clinic not found.',
            'day_of_week.required' => 'The day of the week is required.',
            'day_of_week.string' => 'The day of the week must be a string.',
            'day_of_week.in' => 'The selected day of the week is not valid.',
            'start_time.required' => 'Start time is required.',
            'start_time.date_format' => 'Invalid start time format. Use H:i (e.g., 09:00).',
            'end_time.required' => 'End time is required.',
            'end_time.date_format' => 'Invalid end time format. Use H:i (e.g., 11:00).',
            'end_time.after' => 'The end time must be after the start time.',
            // 'end_time.after_or_equal' => 'The end time must be at least 15 minutes after the start time.',
            'appointment_duration.required' => 'Appointment Duration is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'error' => true,
            'message' => 'Bad Request',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
