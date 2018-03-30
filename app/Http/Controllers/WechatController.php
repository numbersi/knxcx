<?php
/**
 * Created by PhpStorm.
 * User: si
 * Date: 2017/8/18
 * Time: 23:27
 */

namespace App\Http\Controllers;


use App\Http\Server\WechatMessageSever;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;
use function Qiniu\waterText;

class WechatController extends Controller
{

    public function wechat(Request $request)
    {
        $log = new Log();
        $config = [
            'app_id' => env('WECHAT_APPID', 'your-app-id'),         // AppID
            'secret' => env('WECHAT_SECRET', 'your-app-secret'),     // AppSecret
            'token' => env('WECHAT_TOKEN', 'your-token'),          // Token
            'aes_key' => env('WECHAT_AES_KEY', ''),
            'log' => [
                'level' => 'debug',
                'file' => storage_path(). '/wechat.log',
            ],
        ];

        $app = Factory::officialAccount($config);
        $wmServer = new WechatMessageSever();

        $app->server->push(function ($message){
            switch ($message['MsgType']) {
                case 'event':
                    switch ($message->Event) {
                        case 'subscribe':
                            return '欢迎订阅 快鸟先飞';
                            break;
                        default:
                            break;
                    }
                    break;
                case 'text':

                    $openId = $message['FromUserName'];
                    return  WechatMessageSever::index($message['Content'],$openId);
                    break;
                case 'image':

                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });

        /*        $app->server->push(function($message) use ($wmServer){

                    switch ($message['MsgType']) {
                        case 'event':
                            switch ($message->Event) {
                                case 'subscribe':
                                    return '欢迎订阅 快鸟先飞';
                                    break;
                                default:
                                    break;
                            }
                            break;
                        case 'text':
                            $openId = $message->FromUserName;
                            return $wmServer->index($message->Content,$openId);
                            break;
                        case 'image':
                            return '收到图片消息';
                            break;
                        case 'voice':
                            return '收到语音消息';
                            break;
                        case 'video':
                            return '收到视频消息';
                            break;
                        case 'location':
                            return '收到坐标消息';
                            break;
                        case 'link':
                            return '收到链接消息';
                            break;
                        // ... 其它消息
                        default:
                            return '收到其它消息';
                            break;
                    }

                });*/


        return $app->server->serve();
    }
}