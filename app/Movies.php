<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    //
    protected $table = 'movies';

//    public function getVideoInfoAttribute($v)
//    {
//        return json_decode($v, true);
//    }
//    public function getVideoListAttribute($v)
//    {
//        return json_decode($v, true);
//    }
    public function getSdsdsAttribute()
    {
        return '1';
    }
    protected $casts = [
        'video_info' => 'array',
        'video_list' => 'array',
    ];
}
