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
    $r = encrypt(123);
    var_dump($r);
});

Route::group([
    'prefix'=>'api' ,
], function ($route) {
    $route->post('xcxLogin','AuthController@xcxLogin');
    $route::post('/addPostImages','PostController@addPostImages');
    $route::get('/cateAll','CategoryController@index');
    $route::get('/wechat','WechatController@wechat');
    $route->group([    'middleware'=>'refresh.token' ], function ($route) {
        $route::post('/checkToken','AuthController@checkToken');
        $route::post('/getMeData','AuthController@getMeData');
        $route::post('/inputInviteCode','AuthController@inputInviteCode');
        $route::post('/getPostsByCateId','PostController@getPostsByCateId');
        $route::get('/delPost/{post}','PostController@delPost');
        $route::post('/addPost','PostController@addPost');
        $route::post('/getLinks','PostController@getLinks');
    });
});
