<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Requests\CreateGalleryRequest;
use Illuminate\Foundation\Auth\User;
use App\Http\Requests\UpdateGalleryRequest;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $galleries = Gallery::with('galleryImages', 'user')->limit($request->header('numOfGalleries'))->get();

        return $galleries;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGalleryRequest $request)
    {
        $data = $request->validated();
        $user = auth('api')->user();
        $user = User::findOrFail($user->id);
        $gallery = Gallery::create([
            "title" => $data["title"],
            "description" => $data["description"],
            "user_id" => $user['id']
        ]);
        foreach ($data['images'] as $imagesUrl) {
            foreach ($imagesUrl as $url) {
                $gallery->addGalleryImages($url, $gallery['id']);
            }
        }
        return $gallery;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::with('galleryImages', 'user', 'comments', 'comments.user')->findOrFail($id);
        return $gallery;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request, $id)
    {
        $data = $request->validated();
        $gallery = Gallery::findOrFail($id);
        $user = auth('api')->user();
        if($user->id === $gallery->user_id){
            $gallery->update($data);
            foreach ($data['images'] as $imagesUrl) {
                foreach ($imagesUrl as $url) {
                    $gallery->updateGalleryImages($url, $gallery['id']);
                }
            }
        }
        return $gallery;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::with('galleryImages', 'comments')->findOrFail($id);
        $user = auth('api')->user();
        if($user->id === $gallery->user_id){
            $gallery->galleryImages()->delete();
            $gallery->comments()->delete();
            $gallery->delete();
        }
        return $gallery;
    }
}
