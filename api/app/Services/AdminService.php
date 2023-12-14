<?php

namespace App\Services;

use App\Models\User;

class AdminService
{
    private User $user;
    private int $usersList;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->usersList = config('pagination.admin-service-get-users');
    }

    public function getUsers() {
        return $this->user->paginate($this->usersList);
    }

    public function seedUsers(int $count) {
        return $this->user->factory()->count($count)->create();
    }
}
