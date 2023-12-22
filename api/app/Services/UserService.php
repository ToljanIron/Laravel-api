<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function searchUsers(string $email)
    {
        return User::when($email, function ($query) use ($email) {
            return $query->where('email', 'like', "%{$email}%")
                         ->where('id', '!=', auth()->user()->id);
        })->limit(10)->get();
    }
}
