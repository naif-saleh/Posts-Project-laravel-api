<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Like extends Model
{
   use HasApiTokens;

    protected $fillable = [
         'user_id',
         'post_id',
    ];

    //Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Relationship with Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
