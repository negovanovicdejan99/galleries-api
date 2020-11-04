<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

}
