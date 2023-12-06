<?php

namespace App\DataTransferObjects;

class RegisterDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $password_confirmation,
    )
    {}
}
