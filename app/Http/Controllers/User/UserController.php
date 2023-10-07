<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\Common\UserResource;
use App\Http\Services\Auth\UserService;
use App\Models\Common\User;
use App\Traits\ResponseMessage;
use Exception;


class UserController extends Controller
{
    use ResponseMessage;

    public  function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index()
    {

            return UserResource::collection(User::all());

    }

    public function show(User $user)
    {

            if (!$user) {
                return $this->SendMessage("User is incorrect or Not Exisit.", 404);
            }
            return new UserResource($user);

    }

    public function update(UserUpdateRequest $request, User $user) {

            // Update the user's data using the validated request data
            if (!$user) {
                return $this->SendMessage("User is incorrect or Not Exisit.", 404);
            }
            $Updated_user = UserService::UpdateUser( $user ,$request);

            $data = new UserResource($Updated_user);

            return $this->SendResponse("User Updated.", $data, 200);

    }

    public function destroy(User $user)
    {

            UserService::DeleteUser($user);
            return $this->SendMessage("User Deleted.", 200);

    }
}
