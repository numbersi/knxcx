<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $is_buy = true;
    protected $fillable = ['title','gold','links','cate_id'];
    public function images(){
        return $this->hasMany(Image::class, 'post_id', 'id');
    }

    public function user(){
        return  $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function  buyers(){
        return $this->belongsToMany(User::class, 'user_buy_post', 'user_id', 'post_id');
    }
}
