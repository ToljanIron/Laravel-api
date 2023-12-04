<?php

namespace App\Services;

use App\DataTransferObjects\CreateUserAddressDTO;
use App\DataTransferObjects\UpdateUserAddressDTO;
use App\Interfaces\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface
{
    public function show()
    {
        $user = auth()->user();

        return $user->userAddresses;
    }

    public function store(CreateUserAddressDTO $addressDTO)
    {
        $user = auth()->user();
        $userAddress = $user->userAddresses;

        if ($userAddress) {
            return response()->json(['message' => 'User address already exists'], 400);
        }

        return $user->userAddresses()->create([
            'user_id' => $user->id,
            'address_line_1' => $addressDTO->address_line_1,
            'state' => $addressDTO->state,
            'city' => $addressDTO->city,
            'zip' => $addressDTO->zip,
            'phone' => $addressDTO->phone
        ]);
    }

    public function update(UpdateUserAddressDTO $addressDTO)
    {
        $user = auth()->user();
        $userAddress = $user->userAddresses()->first();

        return $userAddress->update([
            'address_line_1' => $addressDTO->address_line_1,
            'state' => $addressDTO->state,
            'city' => $addressDTO->city,
            'zip' => $addressDTO->zip,
            'phone' => $addressDTO->phone
        ]);
    }

    public function destroy()
    {
        $user = auth()->user();
        $userAddress = $user->userAddresses;

        return $userAddress->delete();
    }
}
