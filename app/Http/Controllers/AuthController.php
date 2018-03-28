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
        $s = "扣金币项：

1、由于本站成本有限，服务器和数据库存储空间较低,微信公公众号签到的功能，评论功能的开通只为方便大家相互学习和交流，因此不必须要的留言如“签到”，“你好”等，不要发表，否则一律当垃圾评论处理，并扣除所有金币，请大家谅解！

2、投稿功能是为了金币享大家的资源和技术文章而设，审核需要花费本站的人力和时间成本，希望要严格遵守本站的投稿指南要求，如果是明显的垃圾文章，将扣除所有金币！
";
       






        $user = Auth::user();
        return response([
            'data' => [
                'binding' => $user->promoter_id ? true : false,
                'buy_posts' => $user->buy_posts,
                'inviteCode' => $user->inviteCode,
                'gold' => $user->gold,
                'tuiguang' => [
                    '绑定微信公众号获取40积分，复制自己的邀请码，关注[快鸟先飞]，输入【绑定:邀请码】',
                    '签到领取高额积分， 在公众号回复【签到】,每天 1 次(连续签到会更多奖励) 规则： (3+(连续天数)/2)金币	',
                    '如用金币换取的资源下载链接被取消或者下载的资源需要播放密码而没有提供的，请及时向我们反馈，反馈经核实后，奖励10金币！如有谎报，扣除所有金币',
                    '如对本站为本站的发展提出建议并被采纳的奖励10金币！',
                    '投稿资源,发送到numbersi@vip.qq.com 最低50金币',

                ]
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
            GoldServer::addGold($user2, 60);
            if ($user->save()) {
                return response()->json(['data' => ['msg' => '你的邀请人的微信昵称: ' . $user2->name]]);
            }
        }
    }

}
