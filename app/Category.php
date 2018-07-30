<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function posts(){
        return $this->hasMany(Post::class, 'cate_id', 'id');
    }

    public function getIconAttribute($v)
    {
        return  env('QINIU_DOMAIN', 'http://kuainiaobucket.numbersi.cn').'/'.$v;
    }
}
