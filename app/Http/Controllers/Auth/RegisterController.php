<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Common\UserResource;
use App\Http\Services\Auth\UserService;
use App\Traits\ResponseMessage;
use Exception;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    use ResponseMessage;

    public function Register(RegisterRequest $request) {

            $created_user = UserService::CreateUser(
                $request->name,
                $request->email,
                $request->password,
                $request->phone,
                $request->mobile,
                $request->address,
                $request->date_of_birth,
                $request->gender
            );
            $token = $created_user->createToken("apiToken")->plainTextToken;

            $data = [
                "user" => new UserResource($created_user),
                "token" => $token
            ];

            return $this->SendResponse("User Created.",$data, 201);
    }
}
