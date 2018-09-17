<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/10
 * Time: 17:24
 */

namespace oauth;

use oauth\common\Base;
use oauth\common\OAuthException;

class OAuth
{

    private $driver;

    public function __construct($drivername, array $config)
    {
        $classname = "oauth\\driver\\" . ucfirst($drivername);
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
            return $this->driver->authrize($code);
        }
    }

}