<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
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
        /** @var User $user */
        $user = $this->resource;
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'roles' => $user->getRoleNames,
            'permissions' => $this->permissions,
        ];
    }
}
