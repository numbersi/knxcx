<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MoviesListResource extends Resource
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
            'movieName' => $this->movieName,
            'video_info' => $this->getInfo($this->video_info),
        ];
    }

    public function getInfo($info)
    {
        return $info;
    }
}
