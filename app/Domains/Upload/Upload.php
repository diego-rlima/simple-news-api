<?php

namespace App\Domains\Upload;

use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use App\Domains\Upload\Models\Upload as UploadModel;
use App\Domains\Upload\Repositories\UploadRepository;

class Upload
{
    /**
     * The UploadRepository instance.
     *
     * @var UploadRepository
     */
    protected $repository;

    /**
     * The UploadModel instance.
     *
     * @var UploadModel
     */
    protected $model;

    /**
     * Upload constructor.
     *
     * @param  UploadRepository  $repository
     * @param  UploadModel       $model
     */
    public function __construct(UploadRepository $repository, UploadModel $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * Paginating uploads.
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
     * Find an upload.
     *
     * @param  string  $id
     * @return UploadModel
     */
    public function find(string $id): UploadModel
    {
        return $this->repository->findByPublicID($id, true);
    }

    /**
     * Retrieve the upload path in the storage.
     *
     * @param  string  $id
     * @return string
     */
    public function retrieve(string $id)
    {
        $upload = $this->find($id);

        return $this->storagePath($upload->path);
    }

    /**
     * Uploads a file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $field
     * @param  array                     $info
     * @return \App\Domains\Upload\Models\Upload|null
     */
    public function create(Request $request, string $field = 'file', array $info = []): ?UploadModel
    {
        $file = $this->getFileFromRequest($request, $field);

        $path = $info['path'] ?? '/';

        if ($file && $stored = $this->store($file, $path)) {
            $data = $this->formatData($stored, $info);

            return $this->repository->create($data);
        }

        return null;
    }

    /**
     * Updates a file.
     *
     * @param  string                    $id
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $field
     * @param  array                     $info
     * @return \App\Domains\Upload\Models\Upload
     */
    public function update(string $id, Request $request, string $field = 'file', array $info = []): UploadModel
    {
        $file = $this->find($id);
        $fileToUpload = $this->getFileFromRequest($request, $field);

        $path = $info['path'] ?? '/';

        if ($fileToUpload && $stored = $this->store($fileToUpload, $path)) {
            $data = $this->formatData($stored, $info);

            // Deletes the old file from storage.
            $this->deleteFromStorage($file->path);

            $this->repository->update($file, $data);
        }

        return $file;
    }

    /**
     * Save the file on the storage.
     *
     * @param  mixed   $file
     * @param  string  $path
     * @return null|string
     */
    protected function store($file, string $path = '/'): ?string
    {
        if (!$file->isValid()) {
            return null;
        }

        return $file->store($path);
    }

    /**
     * Delete a file.
     *
     * @param  string  $id
     * @return void
     *
     * @throws \Exception
     */
    public function delete(string $id): void
    {
        $file = $this->find($id);
        $deleted = $this->repository->delete($file);

        if ($deleted) {
            $this->deleteFromStorage($file->path);
        }
    }

    /**
     * Gets the storage path.
     *
     * @param  string  $path
     * @return string
     */
    public function storagePath(string $path = ''): string
    {
        return storage_path( 'app/' . $path);
    }

    /**
     * Gets a file from a request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $field
     * @return array|\Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|null
     */
    public function getFileFromRequest(Request $request, string $field = 'file')
    {
        return $request->hasFile($field) ? $request->file($field) : null;
    }

    /**
     * Delete a file from storage.
     *
     * @param  string  $path
     * @return void
     */
    protected function deleteFromStorage(string $path): void
    {
        unlink($this->storagePath($path));
    }

    /**
     * Format the file data.
     *
     * @param  string  $path
     * @param  array   $data
     * @return array
     */
    protected function formatData(string $path, array $data = []): array
    {
        $data['path'] = $path;

        return $data;
    }

    /**
     * Get the UploadModel instance.
     *
     * @return \App\Domains\Upload\Models\Upload
     */
    public function getModel(): UploadModel
    {
        return $this->model;
    }

    /**
     * Get the UploadRepository instance.
     *
     * @return \App\Domains\Upload\Repositories\UploadRepository
     */
    public function getRepository(): UploadRepository
    {
        return $this->repository;
    }
}
