<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\MedicalRecordCreateRequest;
use App\Http\Requests\Management\MedicalRecordUpdateRequest;
use App\Http\Resources\Management\MedicalRecordResource;
use App\Http\Services\Management\ManagementService;
use App\Models\Management\MedicalRecord;
use App\Traits\ResponseMessage;

class MedicalRecordController extends Controller
{
    use ResponseMessage;

    public  function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index()
    {
        return MedicalRecordResource::collection(MedicalRecord::all());
    }

    public function store(MedicalRecordCreateRequest $request)
    {
        $result = ManagementService::createMedicalRecord(

            $request->doctor_id,
            $request->patient_id,
            $request->appointment_id,
            $request->medical_condition,
            $request->diagnosis,
            $request->prescription,
            $request->date_of_visit,
            $request->follow_up_date,
            $request->additional_notes,
            $request->active,
        );

        // If an existing record is found, return it with a status flag
        if ($result['status'] === 'exists') {

            $existrecord = new MedicalRecordResource($result['record']);

            return $this->SendResponse("Medical record for this appointment already exists.", $existrecord , 409);
        }

        elseif ($result['status'] === 'created') {

            $data = new MedicalRecordResource($result['record']);

            return $this->SendResponse("Medical record created successfully", $data, 201);
        }
    }

    public function show(MedicalRecord $medicalrecord)
    {

        if (is_null($medicalrecord)) {
            return $this->SendMessage("Medical Record is incorrect or Not Exisit.", 404);
        }
        return new MedicalRecordResource($medicalrecord);

    }

    public function update(MedicalRecordUpdateRequest $request, MedicalRecord $medicalrecord)
    {

        // Update the user's data using the validated request data
        if (is_null($medicalrecord)) {
            return $this->SendMessage("doctor Schedule is incorrect or Not Exisit.", 404);
        }

        $Updated_medicalrecord = ManagementService::updateMedicalRecord( $medicalrecord ,$request);

        $data = new MedicalRecordResource($Updated_medicalrecord);

        return $this->SendResponse(" Medical Record Updated.", $data, 200);


    }

    public function destroy(MedicalRecord $medicalrecord)
    {
        if (is_null($medicalrecord)) {
            return $this->SendMessage("doctor Schedule is incorrect or Not Exisit.", 404);
        }
        ManagementService::deleteMedicalRecord($medicalrecord);
        return $this->SendMessage("Doctor Schedule Deleted.", 200);

    }
}
