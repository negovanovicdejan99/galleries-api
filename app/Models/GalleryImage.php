<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gallery;

class GalleryImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'imageUrl',
        'post_id'
    ];
    public function gallery () {
        return $this->belongsTo(Gallery::class);
    }
}
