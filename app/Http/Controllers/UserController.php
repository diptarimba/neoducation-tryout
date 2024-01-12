<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'password' => 'required',
                'phone' => 'required',
                'school' => 'required',
                'dob' => 'required'
            ],[
                'name.required' => 'The name field is required.',
                'username.required' => 'The username field is required.',
                'username.unique' => 'The username field is already used.',
                'password.required' => 'The password field is required.',
                'phone.required' => 'The phone field is required.',
                'school.required' => 'The school field is required.',
                'dob.required' => 'The dob field is required.'
            ]);

            $user = User::create(array_merge($request->all(), [
                'password' => bcrypt($request->password),
            ]));
            $user->assignRole('user');

            return response()->json($user, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

    }
}
