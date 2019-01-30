<?php

namespace App\Support\Http;

use App\Support\Domains\Resource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Contracts\Routing\ResponseFactory;

class Response
{
    /**
     * Json Response.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * API resource helper.
     *
     * @var \App\Support\Domains\Resource
     */
    public $resource;

    /**
     * HTTP status code.
     *
     * @var int
     */
    protected $statusCode = JsonResponse::HTTP_OK;

    /**
     * Validation errors.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Create a new class instance.
     *
     * @param  \Illuminate\Contracts\Routing\ResponseFactory  $response
     * @param  \App\Support\Domains\Resource                   $resource
     */
    public function __construct(ResponseFactory $response, Resource $resource)
    {
        $this->response = $response;
        $this->resource = $resource;
    }

    /**
     * Return a 201 response with the given created item.
     *
     * @param  mixed        $item
     * @param  string|null  $resource
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function withCreated($item = null, string $resource = null)
    {
        $this->setStatusCode(JsonResponse::HTTP_CREATED);

        if (is_null($item)) {
            return $this->json();
        }

        return $this->item($item, $resource);
    }

    /**
     * Return a 404 response.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNotFound(string $message = null): JsonResponse
    {
        return $this->setStatusCode(
            JsonResponse::HTTP_NOT_FOUND
        )->withMessage($message ?? __('Not Found'));
    }

    /**
     * Make a 204 response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNoContent(): JsonResponse
    {
        return $this->setStatusCode(
            JsonResponse::HTTP_NO_CONTENT
        )->json();
    }

    /**
     * Return a 429 response.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withTooManyRequests(string $message = null): JsonResponse
    {
        return $this->setStatusCode(
            JsonResponse::HTTP_TOO_MANY_REQUESTS
        )->withMessage($message ?? __('Too Many Requests'));
    }

    /**
     * Return a 401 response.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withUnauthorized(string $message = null): JsonResponse
    {
        return $this->setStatusCode(
            JsonResponse::HTTP_UNAUTHORIZED
        )->withMessage($message ?? __('Unauthorized'));
    }

    /**
     * Return a 500 response.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withInternalServerError(string $message = null): JsonResponse
    {
        return $this->setStatusCode(
            JsonResponse::HTTP_INTERNAL_SERVER_ERROR
        )->withMessage($message ?? __('Internal Server Error'));
    }

    /**
     * Return a 202 response.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withAccepted(string $message = ''): JsonResponse
    {
        return $this->setStatusCode(
            JsonResponse::HTTP_ACCEPTED
        )->withMessage($message);
    }

    /**
     * Return a 422 response.
     *
     * @param  array   $errors
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withInvalid(array $errors = [], $message = null): JsonResponse
    {
        return $this->setStatusCode(
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        )->withErrors($errors)->withMessage($message ?? __('Invalid Data Entered'));
    }

    /**
     * Make a JSON response with the transformed item.
     *
     * @param  mixed        $item
     * @param  string|null  $resource
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function item($item, string $resource = null): JsonResource
    {
        return $this->resource->item($item, $resource);
    }

    /**
     * Make a JSON response with the transformed items.
     *
     * @param  mixed        $items
     * @param  string|null  $resource
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function collection($items, string $resource = null): JsonResource
    {
        return $this->resource->collection($items, $resource);
    }

    /**
     * Make a JSON response.
     *
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function json(array $data = [], array $headers = []): JsonResponse
    {
        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        return $this->response->json($data, $this->statusCode, $headers);
    }

    /**
     * Make a JSON response with a message.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withMessage(string $message): JsonResponse
    {
        return $this->json(compact('message'));
    }

    /**
     * Make a JSON response with messages.
     *
     * @param  array  $messages
     * @return \Illuminate\Http\JsonResponse
     */
    public function withMessages(array $messages): JsonResponse
    {
        return $this->json(compact('messages'));
    }

    /**
     * Append errors to Response.
     *
     * @param  array  $errors
     * @return self
     */
    public function withErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Set HTTP status code.
     *
     * @param  int  $statusCode
     * @return self
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Gets the HTTP status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
