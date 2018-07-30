<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'Numbersi';
});
Route::group([
    'prefix'=>'movie' ,
], function ($route) {
    $route->get('/','MoviesController@index');
    $route->get('/movieList','MoviesController@lists');
    $route->get('/getMovieLinks/{movies}','MoviesController@getMovieLinks');


    //电影
    $route->get('/dy','MoviesController@dy');
});

Route::group([
    'prefix'=>'dy' ,
], function ($route) {
    $route->get('/','MoviesController@dy');

    $route->get('/{dy}','MoviesController@dyInfo');
});


Route::any('/wechat','WechatController@wechat');
Route::group([
    'prefix'=>'api' ,
], function ($route) {
    $route->post('xcxLogin','AuthController@xcxLogin');
    $route::post('/addPostImages','PostController@addPostImages');
    $route::get('/postNotice','PostController@PostNotice');
    $route::get('/cateAll','CategoryController@index');
    $route->group([    'middleware'=>'refresh.token' ], function ($route) {
        $route::post('/checkToken','AuthController@checkToken');
        $route::post('/getMeData','AuthController@getMeData');
        $route::post('/shareG','ShareController@shareG');
        $route::post('/inputInviteCode','AuthController@inputInviteCode');
        $route::post('/getPostsByCateId','PostController@getPostsByCateId');
        $route::get('/delPost/{post}','PostController@delPost');
        $route::post('/addPost','PostController@addPost');
        $route::post('/getLinks','PostController@getLinks');
    });
});
Route::post('/images', function ( Illuminate\Http\Request $request) {
    $disk = Storage::disk('qiniu2');
    $image = $request->image;
    $r = $disk->put('postImage', $image);
    return $r;
});

