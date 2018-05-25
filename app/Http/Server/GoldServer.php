<?php
/**
 * Created by PhpStorm.
 * User: si
 * Date: 2017/8/18
 * Time: 17:00
 */

namespace App\Http\Server;


use App\User;

class GoldServer
{

    public static function addGold($id,$gold)
    {
        return 123;
        $user = User::find($id);
        if ($user) {
            $user->gold +=$gold;
            $user->save();
            return $user->gold;

        }
        return 0;

    }
}