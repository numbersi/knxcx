<?php

namespace App\Http\Controllers;

use App\Dy;
use App\Http\Resources\MoviesListCollection;
use App\Http\Resources\MoviesResource;
use App\Movies;

class MoviesController extends Controller
{
    //
    public function index()
    {
        return view('movie');
    }
    public function lists()
    {
        $list = \App\Movies::select('id','movieName','video_info')->paginate(10);
        return $list;
        return new  MoviesListCollection($list);
    }
    public function getMovieLinks(Movies $movies)
    {
        return new MoviesResource($movies);
    }
    public function dy()
    {
        return view('dy');
    }
    public function dyInfo(Dy $dy)
    {
        return view('dyPlay',['data'=>$dy]);
    }
}
