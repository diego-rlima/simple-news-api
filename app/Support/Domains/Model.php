<?php

namespace App\Support\Domains;

use Illuminate\Database\Eloquent\Model as DefaultModel;

abstract class Model extends DefaultModel
{
    /**
     * Define the default resource class.
     *
     * @return string
     */
    abstract static public function defaultResource(): string;

    /**
     * Define the default resource collection class.
     *
     * @return string|null
     */
    abstract static public function defaultResourceCollection(): ?string;

    /**
     * Get a public ID for this item.
     *
     * @return string
     */
    public function publicId(): string
    {
        return app('hash.id')->encode($this->id);
    }
}
