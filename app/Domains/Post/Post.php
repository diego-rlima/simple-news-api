<?php

namespace App\Domains\Post;

use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use App\Domains\Post\Models\Post as PostModel;
use App\Domains\Upload\Upload as UploadService;
use App\Domains\Post\Repositories\PostRepository;

class Post
{

    /**
     * The PostRepository instance.
     *
     * @var \App\Domains\Post\Repositories\PostRepository
     */
    protected $repository;

    /**
     * The PostModel instance.
     *
     * @var \App\Domains\Post\Models\Post
     */
    protected $model;

    /**
     * The UploadService instance.
     *
     * @var \App\Domains\Upload\Upload
     */
    protected $uploadService;

    /**
     * Post constructor.
     *
     * @param  \App\Domains\Post\Repositories\PostRepository  $repository
     * @param  \App\Domains\Post\Models\Post                  $model
     * @param  \App\Domains\Upload\Upload                     $uploadService
     */
    public function __construct(PostRepository $repository, PostModel $model, UploadService $uploadService)
    {
        $this->repository = $repository;
        $this->model = $model;
        $this->uploadService = $uploadService;
    }

    /**
     * Find an post.
     *
     * @param  string  $post
     * @return \App\Domains\Post\Models\Post
     */
    public function find(string $post): PostModel
    {
        if ($item = $this->repository->findBySlug($post)) {
            return $item;
        }

        return $this->repository->findByPublicID($post, true);
    }

    /**
     * Create a new post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Domains\Post\Models\Post
     */
    public function create(Request $request): PostModel
    {
        $data = $this->formatData($request);
        $post = $this->repository->create($data);

        $this->repository->syncCategories($post, $this->categories($request));

        $this->saveThumbnail($post, $request);

        return $post;
    }

    /**
     * Update an post.
     *
     * @param  string   $id
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Domains\Post\Models\Post
     */
    public function update(string $id, Request $request): PostModel
    {
        $post = $this->find($id);
        $data = $this->formatData($request);

        $this->repository->update($post, $data);
        $this->repository->syncCategories($post, $this->categories($request));

        // Update or Creates the thumbnail
        if ($post->thumbnail) {
            $this->uploadService->update($post->thumbnail->id, $request, 'thumbnail');
        } else {
            $this->saveThumbnail($post, $request);
        }

        return $post;
    }

    /**
     * Paginating posts.
     *
     * @param  string  $sort
     * @param  string  $order
     * @param  int     $limit
     * @return \Illuminate\Pagination\AbstractPaginator
     */
    public function paginate(string $sort, string $order, int $limit): AbstractPaginator
    {
        return $this->repository->search(true, $limit, true, function($query) use ($sort, $order) {
            return $query->orderBy($sort, $order);
        });
    }

    /**
     * Delete an post from database.
     *
     * @param  string   $id
     * @return void
     *
     * @throws \Exception
     */
    public function delete(string $id): void
    {
        $post = $this->find($id);
        $this->repository->delete($post);
    }

    /**
     * Format the post data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function formatData(Request $request): array
    {
        return $request->only('title', 'slug', 'content');
    }

    /**
     * Format the post data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function categories(Request $request): array
    {
        return collect($request->get('categories'))->map(function ($category) {
            return decode_id($category);
        })->toArray();
    }

    /**
     * Saves a thumbnail.
     *
     * @param  \App\Domains\Post\Models\Post    $post
     * @param  \Illuminate\Http\Request         $request
     */
    protected function saveThumbnail(PostModel $post, Request $request): void
    {
        $thumbnail = $this->uploadService->create($request, 'thumbnail', [
            'name' => $post->title . ' thumbnail'
        ]);

        if ($thumbnail) {
            $post->thumbnail()->save($thumbnail);
        }
    }

    /**
     * Get the PostModel instance.
     *
     * @return \App\Domains\Post\Models\Post
     */
    public function getModel(): PostModel
    {
        return $this->model;
    }

    /**
     * Get the PostRepository instance.
     *
     * @return \App\Domains\Post\Repositories\PostRepository
     */
    public function getRepository(): PostRepository
    {
        return $this->repository;
    }
}
