<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $hidden = [

        'deleted_at',
        'updated_at',
        'created_at'
    ];
    public function getUrlAttribute($value)
    {
        return  env('QINIU_DOMAIN', 'http://kuainiaobucket.numbersi.cn').'/'.$value;
    }

    public function getNameAttribute()
    {
        return $this->attributes['url'];
    }


}
