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
                function ($attribute, $value, $fail) {
                    $start_time = $this->input('start_time');
                    $end_time = $value;

                    $start_time_timestamp = strtotime($start_time);
                    $end_time_timestamp = strtotime($end_time);

                    // Check if end_time is after start_time
                    if ($end_time_timestamp <= $start_time_timestamp) {
                        $fail('The end time must be after the start time.');
                    }

                    // Check if end_time is at least 15 minutes after start_time
                    if ($end_time_timestamp < ($start_time_timestamp + 15 * 60)) {
                        $fail('The end time must be at least 15 minutes after the start time.');
                    }
                },
                //'after:start_time', // Ensure end_time is after start_time
                //'after_or_equal:start_time(i+15)', // Ensure end_time is at least 15 minutes after start_time
            ],
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
            // 'end_time.after' => 'The end time must be after the start time.',
            // 'end_time.after_or_equal' => 'The end time must be at least 15 minutes after the start time.',
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
