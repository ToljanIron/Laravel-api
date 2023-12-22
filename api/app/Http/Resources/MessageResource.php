<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'chat_id' => $this->chat->id,
            'sender' => new UserResource($this->user),
            'recipients' =>new UserResource($this->chat->users->where('id', '!=', $this->user->id)->first()),
            'content' => $this->content,
            'created_at' => Carbon::parse($this->created_at)->format('d.m H:i'),
        ];
    }
}
