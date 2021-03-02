<?php


namespace Yan9\Orderforys\Utils;


class SignService
{
    public static function getUrlSing($appId,$appSecret)
    {
        $params = self::getSign($appId,$appSecret);
        return 'app_id='.$params['app_id'].'&nonce='.$params['nonce'].'&sign='.$params['sign'].'&timestamp='.$params['timestamp'].'&signature='.$params['signature'];
    }

    public static function getSign($appId,$appSecret)
    {
        $date = strtotime(date('YmdHis'));
        $nonce = self::random(13);
        $str = "app_id=" . $appId . "&nonce=" . $nonce . "&sign=sha256&timestamp=" . $date;
        $sign = hash_hmac('sha256', $str, $appSecret, false);
        return [
            'app_id' => $appId,
            'nonce' => $nonce,
            'sign' => 'sha256',
            'timestamp' => $date,
            'signature' => $sign
        ];
    }

    public static function random($length = 6, $type = 'string', $convert = 0)
    {
        $config = array(
        'number' => '1234567890',
        'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        );

        if (!isset($config[$type]))
            $type = 'string';
        $string = $config[$type];

        $code = '';
        $strlen = strlen($string) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{mt_rand(0, $strlen)};
        }
        if (!empty($convert)) {
            $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
        }
        return $code;
    }
}
