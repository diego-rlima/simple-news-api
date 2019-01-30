<?php

namespace App\Support\Hash;

use Hashids\Hashids;

class ID
{
    /**
     * The alphabet string.
     *
     * @var string
     */
    protected $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    /**
     * The minimum hash length.
     *
     * @var int
     */
    protected $minHashLength = 7;

    /**
     * The salt string.
     *
     * @var string
     */
    protected $salt;

    /**
     * The Hashids instance.
     *
     * @var string
     */
    protected $hash;

    /**
     * Creates a new class instance.
     */
    public function __construct()
    {
        $this->salt = config('app.key');

        $this->hash = new Hashids($this->salt, $this->minHashLength, $this->alphabet);
    }

    /**
     * Encode parameters to generate a hash.
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function encode($value): ?string
    {
        return $this->hash->encode($value);
    }

    /**
     * Decode a hash to the original parameter values.
     *
     * @param  string  $hashed
     * @return string|null
     */
    public function decode(string $hashed): ?string
    {
        return array_first($this->hash->decode($hashed));
    }
}
