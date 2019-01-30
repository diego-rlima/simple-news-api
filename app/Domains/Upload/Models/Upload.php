<?php

namespace App\Domains\Upload\Models;

use App\Support\Domains\Model;

class Upload extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the variations for the file.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the parent file that owns this one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get all of the owning models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Define the default resource class.
     *
     * @return string
     */
    public static function defaultResource(): string
    {
        return \App\Domains\Upload\Resources\UploadResource::class;
    }

    /**
     * Define the default resource collection class.
     *
     * @return string|null
     */
    public static function defaultResourceCollection(): ?string
    {
        return \App\Domains\Upload\Resources\UploadResourceCollection::class;
    }
}
