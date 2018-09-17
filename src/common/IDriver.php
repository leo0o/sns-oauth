<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/10
 * Time: 17:37
 */

namespace oauth\common;


interface IDriver
{
    public function getAccessToken($code);

    public function getUserInfo($accessToken, $openid);

    public function authrize($code);
}