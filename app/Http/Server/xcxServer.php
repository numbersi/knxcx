<?php
/**
 * Created by PhpStorm.
 * User: SI
 * Date: 2018/3/14
 * Time: 14:15
 */
namespace App\Http\Server
;

use EasyWeChat\Factory;

class xcxServer
{
    protected $app ;
    public function __construct()
    {
        $config = [
            'app_id' => env('XCX_APPID'),

            'secret' => env('XCX_SECRET'),
            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => storage_path().'/xcx.log',
            ],
        ];

        $this->app =  Factory::miniProgram($config);
    }

    public  function getApp()
    {
        return $this->app;
    }

    public  function getOpenID($code)
    {
     //   return $this->app->access_token->getToken();


       return $this->app->auth->session($code)['openid'];

    }
}