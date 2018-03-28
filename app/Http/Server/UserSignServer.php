<?php
/**
 * Created by PhpStorm.
 * User: si
 * Date: 2017/8/18
 * Time: 21:36
 */

namespace App\Http\Server;


use App\UserSign;
use Carbon\Carbon;

class UserSignServer
{

    public static function sign($user_id)
    {



     //判断今天是否签到
        $today = Carbon::today()->toDateString();
        $nowTime = Carbon::now();
        $yesterday = Carbon::yesterday()->toDateString();
        $sign_num = 1;
        $todaySign = UserSign::whereDate('updated_at', $today)->
                where('user_id',$user_id)->first();

        if (is_null($todaySign)) {
                $yesterdaySign =  UserSign::whereDate('updated_at', $yesterday)->
                where('user_id',$user_id)->first();
            if (is_null($yesterdaySign)) {

                $userSign = UserSign::where('user_id',$user_id)->first();
                if (is_null($userSign)) {
                    UserSign::create(
                        compact('user_id','sign_num')
                    );
                }else{
                    $userSign->sign_num = $sign_num;
                    $userSign->updated_at = $nowTime;
                    $userSign->save();
                }

            }else{

                $yesterdaySign->sign_num +=1;

                if ($yesterdaySign->sign_num >30) {
                    $yesterdaySign->sign_num = 1;
                }
                $sign_num = $yesterdaySign->sign_num;
                $yesterdaySign->updated_at=$nowTime;
                $yesterdaySign->save();
            }
            $addGold = 3 + floor($sign_num/2);
            $golds = GoldServer::addGold($user_id,$addGold);
            return '签到成功,增加了3个金币,连续签到'.$sign_num.'天,奖励'.floor($sign_num/2).'个金币 共计:'.$golds.'个金币';
        }

        return '今天已经签过,请勿重复操作!';

    }
}