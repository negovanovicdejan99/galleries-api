<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gallery;

class UserController extends Controller
{
    public function show(Request $request, $id) {
        $user = User::findOrFail($id);
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

        $galleries = $galleriesQuery->where('user_id', $id)->take($request->header('pagination'))
        ->get();

        $count = $galleriesQuery->count();

        return [$user, $galleries, $count];
    }
}
