<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GalleryImage;
use App\Models\User;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function addGalleryImages($url, $id) {
        return $this->galleryImages()->create([
            'imageUrl' => $url,
            'gallery_id' => $id
        ]);
    }
    public function galleryImages() {
        return $this->hasMany(GalleryImage::class);
    }
}
