<?php

namespace App\Http\Controllers;

use App\Http\Server\GoldServer;
use App\Http\Server\xcxServer;
use App\User;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    //小程序登陆
    public function xcxLogin(Request $request)
    {
        /*[
      "code" => "001ndCZ62pEkEL0vilY62IFCZ62ndCZr"
      "userInfo" => array:7 [
        "nickName" => "贺"
        "gender" => 1
        "language" => "zh_CN"
        "city" => null
        "province" => null
        "country" => "Iceland"
        "avatarUrl" => "https*/
        $userInfo = $request->userInfo;
//        dd($userInfo);
        $code = $request->code;
        $xcxServer = new xcxServer();
        if ($code) {
            $openid = $xcxServer->getOpenID($code);
            if ($openid) {
                $user = User::where(['xcxOpenid' => $openid])->first();
                $string = str_random(8);
                if (!$user) {
                    $user = User::create(['xcxOpenid' => $openid,
                        'name' => $userInfo['nickName'],
                        'inviteCode' => $string
                    ]);
                }
                $token = auth()->login($user);
                return response()->json(['token' => $token], 201);
            }
        }
    }


    public function login(Request $request)
    {
        // 验证规则，由于业务需求，这里我更改了一下登录的用户名，使用手机号码登录

        $rules = [
            'email' => [
                'required',
                'exists:users',
            ],
            'password' => 'required|string|min:6|max:20',
        ];

        // 验证参数，如果验证失败，则会抛出 ValidationException 的异常
        $params = $this->validate($request, $rules);

        // 使用 Auth 登录用户，如果登录成功，则返回 201 的 code 和 token，如果登录失败则返回
        return ($token = Auth::guard('api')->attempt($params))
            ? response(['token' => 'bearer ' . $token], 201)
            : response(['error' => '账号或密码错误'], 400);
    }

    public function checkToken()
    {
        $user = \auth('api')->user();
        dd($user);

    }

    public function getMeData()
    {
        $user = Auth::user();
        return response([
            'data' => [
                'binding' => $user->promoter_id ? true : false,
                'buy_posts' => $user->buy_posts,
                'inviteCode' => $user->inviteCode,
                'wxOpenid' => $user->wxOpenid,
                'xcxOpenid' => $user->xcxOpenid,
                'gold' => $user->gold,
//                'tuiguang' => [
//
//                    ' 点击口令-->复制，粘贴到公众号 发送 获取60金币',
//                    '绑定微信公众号获取60积分，推荐人获取30积分的奖励',
//                    '签到领取高额积分， 在公众号回复【签到】,每天 1 次(连续签到会更 多奖励) 规则： (3+(连续天数)/2)积分	',
//                    '投稿教程，通过审核的，可以获取别人兑换积分70%的奖励',
//                ]
            ],]);
    }

    public function inputInviteCode(Request $request)
    {
        $inviteCode = $request->inviteCode;
        $user = Auth::user();
        if ($user->promoter_id) {

            return response()->json(['data' => ['msg' => '你已经有了邀请人']]);
        }
        if ($inviteCode) {

            $user2 = User::where('inviteCode', $inviteCode)->first();
            if (!$user2) {
                return response()->json(['data' => ['msg' => '无效的邀请码']]);
            }
            $user->promoter_id = $user2->id;
            GoldServer::addGold($user2->id, 60);
            if ($user->save()) {
                return response()->json(['data' => ['msg' => '你的邀请人的微信昵称: ' . $user2->name]]);
            }
        }
    }

}
