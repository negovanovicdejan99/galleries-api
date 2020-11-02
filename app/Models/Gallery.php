<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GalleryImage;

class Gallery extends Model
{
    use HasFactory;

    public function galleryImages() {
        return $this->hasMany(GalleryImage::class);
    }
}
