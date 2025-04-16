<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'user_id',
    ];

    //Relationship with Post
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    //Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Generate Slug
    public function CategorySulg()
    {
        //Generate Slug
        $this->slug = Str::slug($this->name, '-');
        //Return Slug
        return $this->slug;
    }
}
