<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Gallery;

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
        return $authUser = User::findOrFail($user->id);
    }
    public function authUserGallery(Request $request) 
    {
        $user = auth('api')->user();

        $galleriesQuery = Gallery::query();
        $galleriesQuery->with('user', 'galleryImages');
        $search = $request->header('searchText');
        $galleriesQuery->where( functioN($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orwhereHas('user', function($que) use ($search) {
                    $que->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                });
        });

        $galleries = $galleriesQuery->where('user_id', $user->id)->take($request->header('pagination'))
        ->get();

        $count = $galleriesQuery->count();

        return [$user, $galleries, $count];
    }
}
