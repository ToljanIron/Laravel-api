<?php

namespace App\DataTransferObjects;

class LoginDTO
{
    public readonly string $email;
    public readonly string $password;

    public function __construct(
        $email,
        $password,
    )
    {
        $this->email = $email;
        $this->password = $password;
    }
}
