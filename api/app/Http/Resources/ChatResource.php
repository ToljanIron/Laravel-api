<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $usersData = $this->users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
            ];
        });

        return [
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'users' => $usersData->toArray(),
            'created_at' => $this->created_at->format('d.m H:i'),
            'message' => MessageResource::collection($this->messages)
        ];
    }
}
