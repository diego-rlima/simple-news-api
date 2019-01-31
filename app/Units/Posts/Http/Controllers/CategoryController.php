<?php

namespace App\Units\Posts\Http\Controllers;

use App\Support\Http\Response;
use App\Support\Http\Parameters;
use App\Support\Http\ApiController;
use App\Domains\Post\Category as CategoryService;
use App\Units\Posts\Http\Requests\CreateCategoryRequest;
use App\Units\Posts\Http\Requests\UpdateCategoryRequest;
use App\Units\Posts\Http\Requests\DestroyCategoryRequest;

class CategoryController extends ApiController
{
    /**
     * The CategoryService instance.
     *
     * @var \App\Domains\Post\Category
     */
    protected $service;

    /**
     * Creates a new class instance.
     *
     * @param  \App\Support\Http\Response    $response
     * @param  \App\Support\Http\Parameters  $parameters
     * @param  \App\Domains\Post\Category     $service
     */
    public function __construct(Response $response, Parameters $parameters, CategoryService $service)
    {
        parent::__construct($response, $parameters);
        $this->service = $service;
    }

    /**
     * List all categories.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        $sort = $this->parameters->sort();
        $order = $this->parameters->order();
        $limit = $this->parameters->limit();

        $categories = $this->service->paginate($sort, $order, $limit);

        return $this->response->collection($categories);
    }

    /**
     * Saves a new category to the database.
     *
     * @param  \App\Units\Posts\Http\Requests\CreateCategoryRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = $this->service->create($request);

        return $this->response->withCreated($category);
    }

    /**
     * Updates an category.
     *
     * @param  \App\Units\Posts\Http\Requests\UpdateCategoryRequest  $request
     * @param  string             $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $this->service->update($id, $request);

        return $this->response->withAccepted('Categoria atualizada com sucesso');
    }

    /**
     * Removes an category.
     *
     * @param  \App\Units\Posts\Http\Requests\DestroyCategoryRequest  $request
     * @param  string                                             $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function destroy(DestroyCategoryRequest $request, string $id)
    {
        $this->service->delete($id);

        return $this->response->withNoContent();
    }

    /**
     * Retrieve data from a category.
     *
     * @param  string  $category
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(string $category)
    {
        $category = $this->service->find($category);
        return $this->response->item($category);
    }
}
