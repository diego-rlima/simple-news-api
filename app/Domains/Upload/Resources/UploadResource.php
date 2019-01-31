<?php

namespace App\Domains\Upload\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
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
            'name' => $this->name,
            'path' => $this->path,
            'data' => $this->data,
            'created_at' => $this->created_at,
        ];
    }
}
