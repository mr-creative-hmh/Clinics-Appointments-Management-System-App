<?php

namespace App\Http\Controllers\User\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SecretaryCreateRequest;
use App\Http\Requests\User\SecretaryUpdateRequest;
use App\Http\Resources\Users\SecretaryResource;
use App\Http\Services\User\RolesService;
use App\Models\User\Secretary;
use App\Traits\ResponseMessage;
use Exception;

class SecretaryController extends Controller
{
    use ResponseMessage;

    public  function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index()
    {

        return SecretaryResource::collection(Secretary::all());

    }

    public function store(SecretaryCreateRequest $request)
    {

        $created_Secretary = RolesService::CreateSecretary(
            $request->name,
            $request->email,
            $request->password,
            $request->phone,
            $request->mobile,
            $request->address,
            $request->date_of_birth,
            $request->gender,
            $request->additional_info
        );

        $token = $created_Secretary->user->createToken("apiToken")->plainTextToken;

        $data = [
            "Secretary" => new SecretaryResource($created_Secretary),
            "token" => $token
        ];

        return $this->SendResponse("Secretary Created.",$data, 201);


    }

    public function show(Secretary $secretary)
    {

        if (is_null($secretary)) {
            return $this->SendMessage("Secretary is incorrect or Not Exisit.", 404);
        }
        return new SecretaryResource($secretary);

    }

    public function update(SecretaryUpdateRequest $request, Secretary $secretary)
    {

        // Check if the Secretary exists
        if (is_null($secretary)) {
            return $this->SendMessage("Secretary is incorrect or does not exist.", 404);
        }

        // Update the Secretary's data using the RolesService
        $updatedsecretary = RolesService::UpdateSecretary($secretary, $request);

        $data = new SecretaryResource($updatedsecretary);

        return $this->SendResponse("Secretary Updated.", $data, 200);

    }

    public function destroy(Secretary $secretary)
    {
        // Check if the Secretary exists
        if (is_null($secretary)) {
            return $this->SendMessage("Secretary is incorrect or does not exist.", 404);
        }

        RolesService::DeleteSecretary($secretary);
        return $this->SendMessage("Secretary Deleted.", 200);

    }
}
