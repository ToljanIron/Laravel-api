<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\CreateUserAddressDTO;
use App\DataTransferObjects\UpdateUserAddressDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\CreateUserAddressRequest;
use App\Http\Requests\Address\UpdateUserAddressRequest;
use App\Http\Requests\Address\UploadUserAvatarRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $profileService)
    {}

    public function show()
    {
        try {
            $userAddress = $this->profileService->show();
            return response()->json(['success' => $userAddress], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function store(CreateUserAddressRequest $addressRequest)
    {
        try {
            $addressDTO = CreateUserAddressDTO::fromRequest($addressRequest);
            $userAddress = $this->profileService->store($addressDTO);

            return response()->json(['success' => $userAddress], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function uploadAvatar(UploadUserAvatarRequest $avatarRequest)
    {
        try {
            $avatarUrl = $this->profileService->uploadAvatar($avatarRequest->file('avatar'));

            return response()->json(['success' => 'Avatar uploaded successfully', 'url' => $avatarUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateUserAddressRequest $addressRequest)
    {
        try {
            $addressDTO = UpdateUserAddressDTO::fromRequest($addressRequest);
            $userAddressUp = $this->profileService->update($addressDTO);

            return response()->json(['success' => $userAddressUp], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function updateAvatar(UploadUserAvatarRequest $avatarRequest)
    {
        try {
            $avatarUrl = $this->profileService->updateAvatar($avatarRequest->file('avatar'));

            return response()->json(['success' => 'Avatar updated successfully', 'url' => $avatarUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy()
    {
        try {
            $this->profileService->destroy();

            return response()->json(['success' => 'The address has been successfully deleted'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function removeAvatar()
    {
        try {
            $this->profileService->removeAvatar();

            return response()->json(['success' => 'Avatar deleted successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
