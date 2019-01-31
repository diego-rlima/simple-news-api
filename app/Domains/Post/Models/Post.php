<?php

namespace App\Domains\Post\Models;

use App\Support\Domains\Model;
use App\Domains\Account\Models\User;
use App\Domains\Upload\Models\Upload;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'content'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['categories', 'author', 'thumbnail'];

    /**
     * The categories that the post belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    /**
     * Get the author that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post's thumbnail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function thumbnail()
    {
        return $this->morphOne(Upload::class, 'owner');
    }

    /**
     * Define the default resource class.
     *
     * @return string
     */
    public static function defaultResource(): string
    {
        return \App\Domains\Post\Resources\PostResource::class;
    }

    /**
     * Define the default resource collection class.
     *
     * @return string|null
     */
    public static function defaultResourceCollection(): ?string
    {
        return \App\Domains\Post\Resources\PostResourceCollection::class;
    }
}
