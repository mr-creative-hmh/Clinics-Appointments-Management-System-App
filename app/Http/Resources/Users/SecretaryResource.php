<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Common\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SecretaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "User" => new UserResource($this->user),
            "AdditionalInfo" => $this->additional_info,
        ];
    }
}
