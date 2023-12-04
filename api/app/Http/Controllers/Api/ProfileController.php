<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\CreateUserAddressRequest;
use App\Http\Requests\Address\UpdateUserAddressRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService){
        $this->profileService = $profileService;
    }

    public function show()
    {
        $userAddress = $this->profileService->show();

        if (!$userAddress) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        return response()->json(['success' => $userAddress], 201);
    }

    public function store(CreateUserAddressRequest $addressRequest)
    {
        $userAddress = $this->profileService->store($addressRequest->getDTO());

        return response()->json($userAddress, 201);
    }

    public function update(UpdateUserAddressRequest $addressRequest)
    {
        $userAddressUp = $this->profileService->update($addressRequest->getDTO());

        if ($userAddressUp) {
            return response()->json(['success' => 'The address has been successfully updated'] , 201);
        }

        return response()->json(['error' => 'There was an error during address update'] , 500);
    }

    public function destroy()
    {
        $deletedAddress = $this->profileService->destroy();

        if ($deletedAddress){
            return response()->json(['success' => 'The address has been successfully deleted'] , 201);
        }

        return response()->json(['error' => 'An error occurred when deleting an address'], 500);
    }
}
