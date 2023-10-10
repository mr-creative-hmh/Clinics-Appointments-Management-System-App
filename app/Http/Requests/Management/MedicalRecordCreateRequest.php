<?php

namespace App\Http\Requests\Management;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MedicalRecordCreateRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'medical_condition' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'date_of_visit' => 'nullable|date',
            'follow_up_date' => 'nullable|date',
            'additional_notes' => 'nullable|string',
            'active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'The doctor is required.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'patient_id.required' => 'The patient is required.',
            'patient_id.exists' => 'The selected patient does not exist.',
            'appointment_id.required' => 'The appointment is required.',
            'appointment_id.exists' => 'The selected appointment does not exist.',
            'date_of_visit.date' => 'The date of visit must be a valid date.',
            'follow_up_date.date' => 'The follow-up date must be a valid date.',
            'active.boolean' => 'The active field must be a boolean value.',
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
