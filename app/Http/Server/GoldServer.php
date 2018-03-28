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

    public static function addGold($user,$gold)
    {
        $user->gold +=$gold;
        $user->save();

        return $user->gold;
    }
}