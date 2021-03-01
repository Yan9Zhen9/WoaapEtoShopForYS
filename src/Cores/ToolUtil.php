<?php


namespace Yan9\Orderforys\Cores;


class ToolUtil
{
    public static function errorResponse($msg, $code = 999, $data = [])
    {
        return ['retcode' => $code, 'data' => $data, 'errmsg' => $msg];
    }
}
