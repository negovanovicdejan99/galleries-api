<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show($id) {
        $user = User::with('galleries', 'galleries.galleryImages')->findOrFail($id);
        return $user;
    }
}
