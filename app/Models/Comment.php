<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Gallery;

class Comment extends Model
{
    protected $fillable = [
        'body',
        'gallery_id',
        'user_id',
    ];
    use HasFactory;
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function gallery() {
        return $this->belongsTo(Gallery::class);
    }
}
