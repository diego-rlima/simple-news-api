<?php

namespace App\Units\Uploads\Http\Controllers;

use App\Support\Http\Response;
use App\Support\Http\Parameters;
use App\Support\Http\ApiController;
use App\Domains\Upload\Upload as UploadService;
use App\Units\Uploads\Http\Requests\CreateUploadRequest;
use App\Units\Uploads\Http\Requests\UpdateUploadRequest;
use App\Units\Uploads\Http\Requests\DestroyUploadRequest;

class UploadController extends ApiController
{
    /**
     * The UploadService instance.
     *
     * @var \App\Domains\Upload\Upload
     */
    protected $service;

    /**
     * Creates a new class instance.
     *
     * @param  \App\Support\Http\Response    $response
     * @param  \App\Support\Http\Parameters  $parameters
     * @param  \App\Domains\Upload\Upload    $service
     */
    public function __construct(Response $response, Parameters $parameters, UploadService $service)
    {
        parent::__construct($response, $parameters);
        $this->service = $service;
    }

    /**
     * List all uploads.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        $sort = $this->parameters->sort();
        $order = $this->parameters->order();
        $limit = $this->parameters->limit();

        $uploads = $this->service->paginate($sort, $order, $limit);

        return $this->response->collection($uploads);
    }

    /**
     * Saves a new upload to the database.
     *
     * @param  \App\Units\Uploads\Http\Requests\CreateUploadRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(CreateUploadRequest $request)
    {
        $upload = $this->service->create($request);

        return $this->response->withCreated($upload);
    }

    /**
     * Updates an upload.
     *
     * @param  \App\Units\Uploads\Http\Requests\UpdateUploadRequest  $request
     * @param  string                                                $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUploadRequest $request, string $id)
    {
        $this->service->update($id, $request);

        return $this->response->withAccepted('Arquivo atualizado com sucesso');
    }

    /**
     * Removes an upload.
     *
     * @param  \App\Units\Uploads\Http\Requests\DestroyUploadRequest  $request
     * @param  string                                                 $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function destroy(DestroyUploadRequest $request, string $id)
    {
        $this->service->delete($id);

        return $this->response->withNoContent();
    }

    /**
     * Retrieve the upload file.
     *
     * @param  string  $id
     * @return mixed
     */
    public function show(string $id)
    {
        $file = $this->service->retrieve($id);
        return response()->file($file);
    }
}
