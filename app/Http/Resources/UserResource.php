<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "role" => $this->getRoleNames(),
            "permissions" => $this->getPermissionsViaRoles()->pluck("name"),
            "federation_id" => $this->federation_id,
            "association_id" => $this->association_id,
            
        ];
    }
}
