<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchUsersRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(public UserService $userService){}

    public function searchUsers(SearchUsersRequest $request)
    {
        $users = $this->userService->searchUsers($request->input('email'));

        if ($users) {
            return response()->json(['success' => $users], 201);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

}
