<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagePaginationResource extends JsonResource
{
    public static $wrap = null;

    public function __construct($resource)
    {
        parent::__construct($resource);
        JsonResource::withoutWrapping();
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'messages' => $this->resource->getCollection()->transform(function($messages) {
                return [
                    'id' => $messages->id,
                    'chat' => $messages->chat,
                    'user' => $messages->user,
                    'content' => $messages->content,
                    'created_at' => Carbon::parse($messages->created_at)->format('d.m H:i'),
                ];
            }),
            'pagination' => [
                'current_page' => $this->resource->currentPage(),
                'last_page'    => $this->resource->lastPage(),
                'per_page'     => $this->resource->perPage(),
                'next_page_url'=> $this->resource->nextPageUrl(),
                'prev_page_url'=> $this->resource->previousPageUrl(),
                'total'        => $this->resource->total(),
                'from'         => $this->resource->firstItem(),
                'to'           => $this->resource->lastItem(),
            ],
        ];
    }
}
