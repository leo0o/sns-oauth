<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/10
 * Time: 17:41
 */

namespace oauth\Driver;

use oauth\Common\Base;
use oauth\Lib\Http;

class Weibo extends Base
{
    const ACCESS_TOKEN_URL = 'https://api.weibo.com/oauth2/access_token';
    const GET_USERINFO_URL = 'https://api.weibo.com/2/users/show.json';

    public function getAccessToken($code)
    {
        $response = Http::post(self::ACCESS_TOKEN_URL, [
            'client_id' => $this->appKey,
            'client_secret' => $this->appSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUrl
        ]);
        return json_decode($response, true);
    }

    public function getUserInfo($accessToken, $openid)
    {
        $response = Http::get(self::GET_USERINFO_URL, [
            'access_token' => $accessToken,
            'uid' => $openid,
        ]);
        return json_decode($response, true);
    }

    public function authrize($code)
    {
        $Result = $this->getAccessToken($code);
        if (!empty($Result['error_code'])) {
            return [
                'status' => false,
                'msg' => json_encode($Result),
                'data' => null
            ];
        }
        $openid = $Result['uid'];
        $accessToken = $Result['access_token'];
        $userInfo = $this->getUserInfo($accessToken, $openid);
        if (!empty($userInfo['error_code'])) {
            return [
                'status' => false,
                'msg' => json_encode($userInfo),
                'data' => null
            ];
        }
        switch ($userInfo['gender']) {
            case 'm' :
                $sex = 1;
                break;
            case 'f' :
                $sex = 2;
                break;
            case 'n' :
                $sex = 0;
                break;
        }
        return [
            'nickname' => $userInfo['screen_name'],
            'openid' => $openid,
            'sex' => $sex,
            'headimgurl' => $userInfo['profile_image_url'],
            'unionid' => ''
        ];
    }

}