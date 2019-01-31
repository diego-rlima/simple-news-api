<?php

namespace App\Domains\Post\Models;

use App\Support\Domains\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];

    /**
     * The posts that belong to the category.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }

    /**
     * Define the default resource class.
     *
     * @return string
     */
    public static function defaultResource(): string
    {
        return \App\Domains\Post\Resources\CategoryResource::class;
    }

    /**
     * Define the default resource collection class.
     *
     * @return string|null
     */
    public static function defaultResourceCollection(): ?string
    {
        return \App\Domains\Post\Resources\CategoryResourceCollection::class;
    }
}
