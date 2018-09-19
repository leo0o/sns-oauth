<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/10
 * Time: 17:41
 */

namespace SNSOAuth\Driver;

use SNSOAuth\Common\Base;
use SNSOAuth\Common\OAuthException;
use SNSOAuth\Lib\Http;

class Qq extends Base
{
    const ACCESS_TOKEN_URL = 'https://graph.qq.com/oauth2.0/token';
    const GET_USERINFO_URL = 'https://graph.qq.com/user/get_user_info';
    const GET_OPENID_URL = 'https://graph.qq.com/oauth2.0/me';

    public function getAccessToken($code)
    {
        $response = Http::get(self::ACCESS_TOKEN_URL, [
            'grant_type' => 'authorization_code',
            'client_id' => $this->appKey,
            'client_secret' => $this->appSecret,
            'code' => $code,
            'redirect_uri' => $this->redirectUrl
        ]);
        if (strpos($response, 'callback') !== false) {
            throw new OAuthException(sprintf('获取accesstoken返回异常，%s', $response));
        }
        $temp = explode('&', $response)[0];
        $accesstoken = explode('=', $temp)[1];
        return ['access_token' => $accesstoken];
    }

    public function getOpenid($accessToken)
    {
        $response = Http::get(self::GET_OPENID_URL, [
            'access_token' => $accessToken,
            'unionid' => '1',
        ]);
        $response = substr($response, 10, -3);
        return json_decode($response, true);
    }

    public function getUserInfo($accessToken, $openid)
    {
        $response = Http::get(self::GET_USERINFO_URL, [
            'access_token' => $accessToken,
            'oauth_consumer_key' => $this->appKey,
            'openid' => $openid,
        ]);
        return json_decode($response, true);
    }

    public function authrize($code)
    {
        $Result = $this->getAccessToken($code);
        $accessToken = $Result['access_token'];
        $openidResponse = $this->getOpenid($accessToken);
        if (!empty($Result['error'])) {
            return [
                'status' => false,
                'msg' => json_encode($Result),
                'data' => null
            ];
        }
        $openid = $openidResponse['openid'];
        $unionid = $openidResponse['unionid'];
        $userInfo = $this->getUserInfo($accessToken, $openid);
        if (empty($userInfo['gender'])) {
            $sex = 1;
        }
        if ($userInfo['gender'] == '女') {
            $sex = 2;
        } else {
            $sex = 1;
        }
        return [
            'nickname' => $userInfo['nickname'],
            'openid' => $openid,
            'sex' => $sex,
            'headimgurl' => $userInfo['figureurl_qq_1'],
            'unionid' => $unionid
        ];
    }

}