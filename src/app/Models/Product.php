<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'name',
    'description',
    'price',
    'image_path',
    'brand',
    'condition',
    'is_sold',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
{
    return $this->belongsToMany(Category::class);
}

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function favoredUsers()
    {
    return $this->belongsToMany(User::class, 'favorites');
    }

    public function comments()
    {
    return $this->hasMany(Comment::class)->latest();
    }
}

