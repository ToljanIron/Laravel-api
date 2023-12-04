<?php

namespace App\Interfaces;

use App\DataTransferObjects\LoginDTO;
use App\DataTransferObjects\RegisterDTO;
use App\Models\User;


interface AuthInterface
{
    public function register(RegisterDTO $registerDTO): User;

    public function login(LoginDTO $loginDTO): bool|array;

    public function createToken(User $user): array;

    public function verifyEmail(int $user_id, string $hash): bool;
}
