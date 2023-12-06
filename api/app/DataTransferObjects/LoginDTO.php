<?php

namespace App\DataTransferObjects;

class LoginDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    )
    {}
}
