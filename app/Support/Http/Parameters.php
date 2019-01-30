<?php

namespace App\Support\Http;

use Illuminate\Http\Request;

class Parameters
{
    /**
     * HTTP Request.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new class instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get order parameter.
     *
     * @param  string  $default
     * @return string
     */
    public function order(string $default = 'desc'): string
    {
        return $this->get('order', $default);
    }

    /**
     * Get sort parameter.
     *
     * @param  string  $default
     * @return string
     */
    public function sort(string $default = 'id'): string
    {
        return $this->get('sort', $default);
    }

    /**
     * Get limit parameter.
     *
     * @param  int  $default
     * @return int
     */
    public function limit(int $default = 20): int
    {
        return intval($this->get('limit', $default));
    }

    /**
     * Get query parameter.
     *
     * @param  string  $name
     * @param  mixed   $default
     * @return mixed
     */
    public function get(string $name, $default = null)
    {
        return $this->request->query($name, $default);
    }
}
