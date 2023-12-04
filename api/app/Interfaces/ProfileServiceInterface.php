<?php

namespace App\Interfaces;

use App\DataTransferObjects\CreateUserAddressDTO;
use App\DataTransferObjects\UpdateUserAddressDTO;

interface ProfileServiceInterface
{
    public function show();

    public function store(CreateUserAddressDTO $addressDTO);

    public function update(UpdateUserAddressDTO $addressDTO);

    public function destroy();
}
