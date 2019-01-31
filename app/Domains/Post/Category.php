<?php

namespace App\Domains\Post;

use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use App\Domains\Post\Repositories\CategoryRepository;
use App\Domains\Post\Models\Category as CategoryModel;

class Category
{

    /**
     * The CategoryRepository instance.
     *
     * @var \App\Domains\Post\Repositories\CategoryRepository
     */
    protected $repository;

    /**
     * The CategoryModel instance.
     *
     * @var \App\Domains\Post\Models\Category
     */
    protected $model;

    /**
     * Category constructor.
     *
     * @param  \App\Domains\Post\Repositories\CategoryRepository  $repository
     * @param  \App\Domains\Post\Models\Category                  $model
     */
    public function __construct(CategoryRepository $repository, CategoryModel $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * Find an category.
     *
     * @param  string  $category
     * @return \App\Domains\Post\Models\Category
     */
    public function find(string $category): CategoryModel
    {
        if ($item = $this->repository->findBySlug($category)) {
            return $item;
        }

        return $this->repository->findByPublicID($category, true);
    }

    /**
     * Create a new category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Domains\Post\Models\Category
     */
    public function create(Request $request): CategoryModel
    {
        $data = $this->formatData($request);
        $category = $this->repository->create($data);

        $this->repository->syncCategories($category, $this->categories($request));

        return $category;
    }

    /**
     * Update an category.
     *
     * @param  string   $id
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Domains\Post\Models\Category
     */
    public function update(string $id, Request $request): CategoryModel
    {
        $category = $this->find($id);
        $data = $this->formatData($request);

        $this->repository->update($category, $data);

        return $category;
    }

    /**
     * Paginating categories.
     *
     * @param  string  $sort
     * @param  string  $order
     * @param  int     $limit
     * @return \Illuminate\Pagination\AbstractPaginator
     */
    public function paginate(string $sort, string $order, int $limit): AbstractPaginator
    {
        return $this->repository->doQuery(function($query) use ($sort, $order) {
            return $query->orderBy($sort, $order);
        }, $limit);
    }

    /**
     * Delete an category from database.
     *
     * @param  string   $id
     * @return void
     *
     * @throws \Exception
     */
    public function delete(string $id): void
    {
        $category = $this->find($id);
        $this->repository->delete($category);
    }

    /**
     * Format the category data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function formatData(Request $request): array
    {
        return $request->only('name', 'slug');
    }

    /**
     * Get the CategoryModel instance.
     *
     * @return \App\Domains\Post\Models\Category
     */
    public function getModel(): CategoryModel
    {
        return $this->model;
    }

    /**
     * Get the CategoryRepository instance.
     *
     * @return \App\Domains\Post\Repositories\CategoryRepository
     */
    public function getRepository(): CategoryRepository
    {
        return $this->repository;
    }
}
