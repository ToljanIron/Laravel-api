<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPaginationResource extends JsonResource
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
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
            'users' => $this->resource->getCollection()->transform(function($users) {
                return [
                    'id' => $users->id,
                    'name' => $users->name,
                    'email' => $users->email,
                    'verified' => isset($users->email_verified_at),
                    'created' => Carbon::parse($users->created_at)->format('d.m H:i')
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
