<?php

namespace App\Services;

use App\DataTransferObjects\LoginDTO;
use App\DataTransferObjects\RegisterDTO;
use App\Events\UserRegistered;
use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

final class AuthService implements AuthInterface
{
    public function register(RegisterDTO $registerDTO): User
    {
        $encryptPassword = Hash::make($registerDTO->password);

        $user = User::create([
            'name'     => $registerDTO->name,
            'email'    => $registerDTO->email,
            'password' => $encryptPassword
        ]);

        $urlVerification = $this->createUrlVerification($user);

        event(new UserRegistered($user, $urlVerification));

        return $user;
    }

    public function login(LoginDTO $loginDTO): bool|array
    {
        if (!auth()->attempt(([
            'email'    => $loginDTO->email,
            'password' => $loginDTO->password
        ]))) {

            return false;
        }

        $user = Auth::user();
        $tokenArr = $this->createToken($user);

        return ['user' => $user, 'token' => $tokenArr['token'], 'expired_at' => $tokenArr['expired_at']];
    }

    public function createToken(User $user): array
    {
        $tokenResult = $user->createToken('authToken');
        $expirationMinutes = config('sanctum.expiration');
        $expiredAt = Date::now()->addMinutes($expirationMinutes);

        return [
            'token'      => $tokenResult->plainTextToken,
            'expired_at' => $expiredAt->toDateTimeString(),
        ];
    }

    public function verifyEmail(int $user_id, string $hash): bool
    {
        $user = User::findOrFail($user_id);
        $expectedHash = sha1($user->getEmailForVerification());

        if ($expectedHash === $hash) {
            $user->markEmailAsVerified();
            return true;
        }

        return false;
    }

    private function createUrlVerification(User $user): string
    {
        return  config('app.frontend_url') . '/verify-email/' . $user->id . '/' . sha1($user->getEmailForVerification());
    }
}
