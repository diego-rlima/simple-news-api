<?php

namespace App\Domains\Post\Resources;

use App\Domains\Account\Resources\UserResource;
use App\Domains\Upload\Resources\UploadResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->publicId(),
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'categories' => new CategoryResourceCollection($this->categories),
            'thumbnail' => new UploadResource($this->thumbnail),
            'author' => new UserResource($this->author),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
