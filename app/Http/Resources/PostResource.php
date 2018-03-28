<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['id' => $this->id,
            'title' => $this->title,
            'cate_id' => $this->cate_id,
            'links' => $this->links,
            'user'=>new UserResource($this->user),
            'images'=>new ImageC($this->user),
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,];
    }
}
