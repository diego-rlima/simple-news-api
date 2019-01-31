<?php

namespace App\Units\Posts\Http\Controllers;

use App\Support\Http\Response;
use App\Support\Http\Parameters;
use App\Support\Http\ApiController;
use App\Domains\Post\Post as PostService;
use App\Units\Posts\Http\Requests\CreatePostRequest;
use App\Units\Posts\Http\Requests\UpdatePostRequest;
use App\Units\Posts\Http\Requests\DestroyPostRequest;

class PostController extends ApiController
{
    /**
     * The PostService instance.
     *
     * @var \App\Domains\Post\Post
     */
    protected $service;

    /**
     * Creates a new class instance.
     *
     * @param  \App\Support\Http\Response    $response
     * @param  \App\Support\Http\Parameters  $parameters
     * @param  \App\Domains\Post\Post     $service
     */
    public function __construct(Response $response, Parameters $parameters, PostService $service)
    {
        parent::__construct($response, $parameters);
        $this->service = $service;
    }

    /**
     * List all posts.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        $sort = $this->parameters->sort();
        $order = $this->parameters->order();
        $limit = $this->parameters->limit();

        $posts = $this->service->paginate($sort, $order, $limit);

        return $this->response->collection($posts);
    }

    /**
     * Saves a new post to the database.
     *
     * @param  \App\Units\Posts\Http\Requests\CreatePostRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(CreatePostRequest $request)
    {
        $post = $this->service->create($request);

        return $this->response->withCreated($post);
    }

    /**
     * Updates an post.
     *
     * @param  \App\Units\Posts\Http\Requests\UpdatePostRequest  $request
     * @param  string             $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $this->service->update($id, $request);

        return $this->response->withAccepted('Postagem atualizada com sucesso');
    }

    /**
     * Removes an post.
     *
     * @param  \App\Units\Posts\Http\Requests\DestroyPostRequest  $request
     * @param  string                                             $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function destroy(DestroyPostRequest $request, string $id)
    {
        $this->service->delete($id);

        return $this->response->withNoContent();
    }

    /**
     * Retrieve data from a post.
     *
     * @param  string  $post
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(string $post)
    {
        $post = $this->service->find($post);
        return $this->response->item($post);
    }
}
