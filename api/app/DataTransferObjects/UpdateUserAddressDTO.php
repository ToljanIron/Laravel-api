<?php

namespace App\DataTransferObjects;

use App\Http\Requests\Address\UpdateUserAddressRequest;

class UpdateUserAddressDTO
{
    public function __construct(
        public readonly string $address_line_1,
        public readonly string $state,
        public readonly string $city,
        public readonly string $zip,
        public readonly string $phone
    )
    {}

    public static function fromRequest(UpdateUserAddressRequest $request): UpdateUserAddressDTO
    {
        return new self(
            $request->input('address_line_1'),
            $request->input('state'),
            $request->input('city'),
            $request->input('zip'),
            $request->input('phone'),
        );
    }
}
