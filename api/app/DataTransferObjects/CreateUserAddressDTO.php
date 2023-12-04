<?php

namespace App\DataTransferObjects;

class CreateUserAddressDTO
{
    public string $address_line_1;
    public string $state;
    public string $city;
    public string $zip;
    public string $phone;

    public function __construct(
        string $address_line_1,
        string $state,
        string $city,
        string $zip,
        string $phone
    )
    {
        $this->address_line_1 = $address_line_1;
        $this->state = $state;
        $this->city = $city;
        $this->zip = $zip;
        $this->phone = $phone;
    }
}
