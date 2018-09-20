<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/10
 * Time: 17:39
 */

namespace SNSOAuth\Driver;

use SNSOAuth\Common\Base;
use SNSOAuth\Common\OAuthException;
use SNSOAuth\Lib\Http;

class Wechat extends Base
{
    const ACCESS_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    const GET_USERINFO_URL = 'https://api.weixin.qq.com/sns/userinfo';

    public function getAccessToken($code)
    {
        $response = Http::get(self::ACCESS_TOKEN_URL, [
            'appid' => $this->appKey,
            'secret' => $this->appSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);
        return json_decode($response, true);
    }

    public function getUserInfo($accessToken, $openid)
    {
        $response = Http::get(self::GET_USERINFO_URL, [
            'access_token' => $accessToken,
            'openid' => $openid,
        ]);
        return json_decode($response, true);
    }

    public function authrize($code)
    {
        $Result = $this->getAccessToken($code);
        if (!empty($Result['errcode'])) {
            throw new OAuthException(sprintf('获取accesstoken返回异常，微信返回：%s', json_encode($Result)));
        }
        $openid = $Result['openid'];
        $accessToken = $Result['access_token'];
        $userInfo = $this->getUserInfo($accessToken, $openid);
        if (!empty($userInfo['errcode'])) {
            throw new OAuthException(sprintf('获取userinfo返回异常，微信返回：%s', json_encode($userInfo)));
        }
        return [
            'nickname' => $userInfo['nickname'],
            'openid' => $userInfo['openid'],
            'sex' => $userInfo['sex'],
            'headimgurl' => $userInfo['headimgurl'],
            'unionid' => $userInfo['unionid']
        ];
    }

}