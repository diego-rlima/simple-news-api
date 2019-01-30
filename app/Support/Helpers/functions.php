<?php

if (!function_exists('encode_id')) {
    /**
     * Encode parameters to generate a hash.
     *
     * @param  string  $id
     * @return string|null
     */
    function encode_id($id): ?string
    {
        if (empty($id)) {
            return null;
        }

        return app('hash.id')->encode($id);
    }
}

if (!function_exists('decode_id')) {
    /**
     * Decode a hash to the original parameter values.
     *
     * @param  string  $encodedId
     * @return string|null
     */
    function decode_id($encodedId): ?string
    {
        return app('hash.id')->decode($encodedId);
    }
}

if (!function_exists('frontend_url')) {
    /**
     * Generate a url for the front end.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @param  bool    $secure
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function frontend_url($path = null, $parameters = [], $secure = null)
    {
        $url = config('api.frontend_url');

        return url($url . $path, $parameters, $secure);
    }
}

