<?php
/**
 * Created by PhpStorm.
 * User: leooo.
 * Date: 2018/9/13
 * Time: 9:43
 */

namespace SNSOAuth\Common;


use Throwable;

class OAuthException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}