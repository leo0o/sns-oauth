<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/10
 * Time: 17:24
 */

namespace SNSOAuth;

use SNSOAuth\Common\Base;
use SNSOAuth\Common\OAuthException;

class OAuth
{

    private $driver;

    public function __construct($drivername, array $config)
    {
        $classname = "SNSOAuth\\Driver\\" . ucfirst($drivername);
        if (!class_exists($classname)) {
            throw new OAuthException("请检查传入的 drivername");
        }

        $this->driver = new $classname($config);
    }

    public function Authrize($code)
    {
        if (!$this->driver instanceof Base) {
            throw new OAuthException("driver 类型异常");
        } else {
            try {
                $result = $this->driver->authrize($code);
            } catch (OAuthException $e) {
                $result = null;
            }
            return $result;
        }
    }

}