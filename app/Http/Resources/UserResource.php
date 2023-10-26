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
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'is_admin' => $this->is_admin,
            'jabatan_id' => $this->jabatan_id,
            'lokasi_id' => $this->lokasi_id,
            'token' => $this->whenNotNull($this->token)
        ];
    }
}
