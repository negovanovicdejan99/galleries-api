<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password']
        ];

        $token = auth('api')->attempt($credentials);

        if(!$token) {
            abort(401, 'Email or password are incorrect!');
        }
        return ['token' => $token];
    }
    public function logout() {
        return auth('api')->logout(true);
    }
    public function refresh() {
        return ['token' => auth('api')->refresh(true)];  
    }
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            'email_verified_at' => now(),
            "password" => Hash::make($data['password']),
        ]);   
        $token = auth('api')->login($user);

        return ['token' => $token];
    }
    public function authUser()
    {
        $user = auth('api')->user();
        return $authUser = User::with('galleries', 'galleries.galleryImages', 'comments')->findOrFail($user->id);
    }
}
