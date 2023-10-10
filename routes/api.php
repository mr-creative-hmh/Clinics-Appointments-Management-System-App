<?php

use App\Http\Controllers\Clinic\CategoryController;
use App\Http\Controllers\Clinic\ClinicController;
use App\Http\Controllers\Management\AppointmentController;
use App\Http\Controllers\Management\DoctorScheduleController;
use App\Http\Controllers\Management\MedicalRecordController;
use App\Http\Controllers\User\Role\DoctorController;
use App\Http\Controllers\User\Role\PatientController;
use App\Http\Controllers\User\Role\SecretaryController;
use App\Http\Controllers\User\Role\SpecializationController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return "tesing";
// });


Route::apiResource("user", UserController::class);
Route::apiResource("doctor",DoctorController::class);
Route::apiResource("patient",PatientController::class);
Route::apiResource("secretary",SecretaryController::class);
Route::apiResource("role", RoleController::class);
Route::apiResource("specialization",SpecializationController::class);
Route::apiResource("category", CategoryController::class);
Route::apiResource("clinic", ClinicController::class);
Route::apiResource("doctorschedule",DoctorScheduleController::class);
Route::apiResource("appointment", AppointmentController::class);
Route::apiResource("medicalrecord", MedicalRecordController::class);
Route::get("appointment/{id}/available-appointments/{date}", [AppointmentController::class, "getAvailableAppointments"]);

//Route::group(['auth:sanctum' => 'role:'], function () { });
