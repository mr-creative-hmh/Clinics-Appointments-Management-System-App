<?php

namespace App\Http\Services\User;

use App\Models\Common\Role;
use App\Models\Common\User;
use App\Models\User\Doctor;
use App\Models\User\Patient;
use App\Models\User\Secretary;
use App\Models\User\Specialization;
use App\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RolesService {

    Use ResponseMessage;

    // Role Functions

    //Create Role

    public static function CreateRole($name)
    {
        $created_role = Role::Create([
            "name" => $name
        ]);
        return $created_role;
    }


    //Update Role
    public static function UpdateRole(Role $role, Request $request)
    {

        $roled = $request->validated();
        $role->update($roled);
        return $role;

    }


    //Delete Role
    public static function DeleteRole(Role $role)
    {
        $role->delete();
    }

    //Specialization Functions

    //Create Specialization
    public static function CreateSpecialization($name)
    {
        $created_specialization = Specialization::Create([
            "name" => $name
        ]);
        return $created_specialization;
    }

    //Update Specialization
    public static function UpdateSpecialization(Specialization $specialization, Request $request)
    {

        $specializationdata = $request->validated();
        $specialization->update($specializationdata);
        return $specialization;

    }

    //Delete Specialization
    public static function DeleteSpecialization(Specialization $specialization)
    {
        $specialization->delete();
    }

    //Doctor Functions

    //Create Doctor
    public static function CreateDoctor($name, $email, $password, $phone, $mobile, $address, $date_of_birth, $gender , $specialization_id , $experience , $additional_info)
    {
        //DB::beginTransaction();
        $created_user = User::Create([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password),
            "phone" => $phone,
            "mobile" => $mobile,
            "address" => $address,
            "date_of_birth" => $date_of_birth,
            "gender" => $gender
        ]);

        $created_doctor = Doctor::Create([
            "user_id" => $created_user->id,
            "specialization_id" => $specialization_id,
            "experience" => $experience,
            "additional_info" => $additional_info
        ]);

        //DB::commit();
        return $created_doctor;
        //DB::rollBack();
    }

    //Update Doctor
    public static function UpdateDoctor(Doctor $doctor, Request $request)
    {
        $doctorData = $request->validated();

        // Find the associated user and update its data
        $user = $doctor->user;

        // Update the user's data
        $user->update($doctorData);

        // Update the doctor's data
        $doctor->update($doctorData);

        return $doctor;
    }



    //Delete Doctor
    public static function DeleteDoctor(Doctor $doctor)
    {
        $user = $doctor->user;
        // First, delete the doctor record from the 'doctors' table
        $doctor->delete();
        // Next, delete the corresponding user record from the 'users' table
        $user->delete();
    }


    //Patient Functions

    //Create Patient
    public static function CreatePatient($name, $email, $password, $phone, $mobile, $address, $date_of_birth, $gender , $wight , $hight , $additional_info)
    {
        //DB::beginTransaction();
        $created_user = User::Create([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password),
            "phone" => $phone,
            "mobile" => $mobile,
            "address" => $address,
            "date_of_birth" => $date_of_birth,
            "gender" => $gender
        ]);

        $created_patient = Patient::Create([
            "user_id" => $created_user->id,
            "wight" => $wight,
            "hight" => $hight,
            "additional_info" => $additional_info
        ]);

        //DB::commit();
        return $created_patient;
        //DB::rollBack();
    }

    //Update Patient
    public static function UpdatePatient(Patient $patient, Request $request)
    {
        $patientData = $request->validated();

        // Find the associated user and update its data
        $user = $patient->user;

        // Update the user's data
        $user->update($patientData);

        // Update the patient's data
        $patient->update($patientData);

        return $patient;
    }



    //Delete Patient
    public static function DeletePatient(Patient $patient)
    {
        $user = $patient->user;
        // First, delete the doctor record from the 'doctors' table
        $patient->delete();
        // Next, delete the corresponding user record from the 'users' table
        $user->delete();
    }


    //Secretary Functions

    //Create Secretary
    public static function CreateSecretary($name, $email, $password, $phone, $mobile, $address, $date_of_birth, $gender , $additional_info)
    {
        //DB::beginTransaction();
        $created_user = User::Create([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password),
            "phone" => $phone,
            "mobile" => $mobile,
            "address" => $address,
            "date_of_birth" => $date_of_birth,
            "gender" => $gender
        ]);

        $created_secretary = Secretary::Create([
            "user_id" => $created_user->id,
            "additional_info" => $additional_info
        ]);

        //DB::commit();
        return $created_secretary;
        //DB::rollBack();
    }

    //Update Secretary
    public static function UpdateSecretary(Secretary $secretary, Request $request)
    {
        $secretaryData = $request->validated();

        // Find the associated user and update its data
        $user = $secretary->user;

        // Update the user's data
        $user->update($secretaryData);

        // Update the Secretary's data
        $secretary->update($secretaryData);

        return $secretary;
    }



    //Delete Secretary
    public static function DeleteSecretary(Secretary $secretary)
    {
        $user = $secretary->user;
        // First, delete the doctor record from the 'doctors' table
        $secretary->delete();
        // Next, delete the corresponding user record from the 'users' table
        $user->delete();
    }
}
