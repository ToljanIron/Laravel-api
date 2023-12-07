<?php

namespace App\Services;

use App\Models\UserAddress;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileService
{
    protected function getUserAddress()
    {
        return auth()->user()->userAddresses()->first();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function show(): mixed
    {
        $userAddress = $this->getUserAddress();

        Log::info('This is some useful information.');
        Log::warning('Something could be going wrong.');
        Log::error('Something is really going wrong.');

        if (!$userAddress) {
            throw new \Exception('Address not found', 404);
        }

        return $userAddress;
    }

    /**
     * @param $dto
     * @return UserAddress
     * @throws \Exception
     */
    public function store($dto): UserAddress
    {
        $user = auth()->user();
        if ($user->userAddresses()->exists()) {
            throw new \Exception('User address already exists', 400);
        }

        $userAddress = new UserAddress();

        $userAddress->user_id = $user->id;
        $userAddress->address_line_1 = $dto->address_line_1;
        $userAddress->state = $dto->state;
        $userAddress->city = $dto->city;
        $userAddress->zip = $dto->zip;
        $userAddress->phone = $dto->phone;
        $userAddress->save();

        return $userAddress;
    }

    /**
     * @param $avatar
     * @param string $disk
     * @return string
     * @throws \Exception
     */
    public function uploadAvatar($avatar, string $disk = 's3'): string
    {
        $user = auth()->user();
        $path = 'avatars-' . Str::random(12) . '-' . $user->id . '.' . $avatar->getClientOriginalExtension();
        $disk = Storage::disk($disk);

        try {
            $disk->put($path, file_get_contents($avatar), 'public');
            $url = $disk->url($path);

            $user->avatar = $url;
            $user->save();

            return $url;
        } catch (\Exception $e) {
            throw new \Exception('Avatar upload failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @param $dto
     * @return UserAddress
     * @throws \Exception
     */
    public function update($dto): UserAddress
    {
        $userAddress = $this->getUserAddress();
        if (!$userAddress) {
            throw new \Exception('User address does not exist', 400);
        }

        $userAddress->address_line_1 = $dto->address_line_1;
        $userAddress->state = $dto->state;
        $userAddress->city = $dto->city;
        $userAddress->zip = $dto->zip;
        $userAddress->phone = $dto->phone;
        $userAddress->save();

        return $userAddress;
    }

    /**
     * @param $avatar
     * @param string $disk
     * @return string
     * @throws \Exception
     */
    public function updateAvatar($avatar, string $disk = 's3'): string
    {
        $user = auth()->user();

        $existingAvatar = $user->avatar;

        if ($existingAvatar) {
            $this->deleteAvatar($existingAvatar, $disk);
        }

        $path = 'avatars-' . Str::random(12) . '-' . $user->id . '.' . $avatar->getClientOriginalExtension();
        $disk = Storage::disk($disk);

        try {
            $disk->put($path, file_get_contents($avatar), 'public');
            $url = $disk->url($path);

            $user->avatar = $url;
            $user->save();

            return $url;
        } catch (\Exception $e) {
            throw new \Exception('Avatar update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function destroy():bool
    {
        $userAddress = $this->getUserAddress();
        if (!$userAddress) {
            throw new \Exception('User address does not exist', 400);
        }

        $userAddress->delete();

        return true;
    }

    /**
     * @param string $disk
     * @return bool
     * @throws \Exception
     */
    public function removeAvatar(string $disk = 's3'): bool
    {
        $user = auth()->user();
        $avatarUrl = $user->avatar;

        if (!$avatarUrl) {
            throw new \Exception('Avatar not found for the user', 404);
        }

        $this->deleteAvatar($avatarUrl, $disk);
        $user->avatar = null;
        $user->save();

        return true;
    }

    /**
     * @param $avatarUrl
     * @param string $disk
     * @return void
     * @throws \Exception
     */
    protected function deleteAvatar($avatarUrl, string $disk = 's3'): void
    {
        $path = parse_url($avatarUrl, PHP_URL_PATH);
        $disk = Storage::disk($disk);

        try {
            if ($disk->exists($path)) {
                $disk->delete($path);
            }
        } catch (\Exception $e) {
            throw new \Exception('Deleting the avatar you are using failed' . $e->getMessage(), 500);
        }
    }
}
