<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/13
 * Time: 15:24
 */

namespace SNSOAuth\Common;

abstract class Base implements IDriver
{
    protected $appKey = '';

    protected $appSecret = '';

    protected $redirectUrl = '';

    public function __construct(array $config)
    {
        $this->init($config);
    }

    public function init(array $config)
    {
        if (!empty($config['appKey'])) {
            $this->appKey = $config['appKey'];
        } else {
            throw new \Exception('appKey 必须存在且不能为空，请注意配置文件中key的大小写');
        }

        if (!empty($config['appSecret'])) {
            $this->appSecret = $config['appSecret'];
        } else {
            throw new \Exception('appSecret 必须存在且不能为空，请注意配置文件中key的大小写');
        }

        if (!empty($config['redirectUrl'])) {
            $this->redirectUrl = $config['redirectUrl'];
        } else {
            throw new \Exception('redirectUrl 必须存在且不能为空，请注意配置文件中key的大小写');
        }
    }

}