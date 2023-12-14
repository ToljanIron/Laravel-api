<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeedUsersRequest;
use App\Http\Resources\UserResource;
use App\Services\AdminService;

class AdminController extends Controller
{
    private AdminService $adminService;
    public function __construct(AdminService $adminService){
        $this->adminService = $adminService;
    }

    public function getUsers(){
        $users = $this->adminService->getUsers();

        if ($users->isEmpty()) {
            return response()->json(['error' => 'No users found'], 404);
        }

        return response()->json(new UserResource($users), 201);
    }

    public function seedUsers(SeedUsersRequest $request)
    {
        return response()->json(['success' => 'Users seeded successfully!'], 201);
        $seedUsers = $this->adminService->seedUsers($request->input('count'));

        if ($seedUsers->isEmpty()) {
            return response()->json(['error' => 'No users found'], 404);
        }

        return response()->json(['success' => 'Users seeded successfully!'], 201);
    }
}
