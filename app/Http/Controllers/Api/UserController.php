<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        Log::info('Fetching all users');

        try {
            $users = User::all();
            Log::info('Users retrieved successfully');
            return response()->json(['data' => $users], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
    
    public function checkRoles(User $user)
    {
        Log::info('Checking roles for user: ', ['user_id' => $user->id]);

        try {
            $roles = $user->getRoleNames(); // Get all roles of the user
            Log::info('Roles retrieved successfully for user', ['roles' => $roles]);
            return response()->json(['roles' => $roles], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
