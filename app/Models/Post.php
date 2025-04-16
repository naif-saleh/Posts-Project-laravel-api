<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function disLikes()
    {
        return $this->hasMany(Dislike::class);
    }

    //Generate Slug
    public function PostSulg()
    {
        //Generate Slug
        $this->slug = Str::slug($this->title, '-');
        //Return Slug
        return $this->slug;
    }
}
