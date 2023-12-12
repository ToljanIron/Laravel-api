<?php

namespace App\Services;

use App\Models\User;

class AdminService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers() {
        return $this->user->all();
    }
}
