<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/13
 * Time: 14:55
 */

namespace oauth\lib;

class Http
{
    private static function init($option = null)
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if ($option !== null) {
                if (array_key_exists('header', $option)) {
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $option['header']);
                }
                curl_setopt($ch, CURLOPT_TIMEOUT, array_key_exists('timeout', $option) ? $option['timeout'] : 30);
            }
            return $ch;
        } else {
            throw new \Exception("服务器不支持curl");
        }
    }

    private static function exec($ch)
    {
        $response = curl_exec($ch);
        if ($response !== false) {
            curl_close($ch);
            return $response;
        } else {
            $errorCode = curl_errno($ch);
            $errorMsg  = curl_error($ch);
            curl_close($ch);
            throw new \Exception(sprintf("curl出错，errmsg:%s, errcode:%s", $errorMsg, $errorCode));
        }
    }

    public static function get($url, $data = null, $options = null)
    {
        $ch = self::init($options);
        $url = rtrim($url, '?');
        if (!is_null($data)) {
            $url .= '?' . http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        return self::exec($ch);
    }

    public static function post($url, $data = null, $options = null)
    {
        $ch = self::init($options);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        if (!is_null($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        return self::exec($ch);
    }
}