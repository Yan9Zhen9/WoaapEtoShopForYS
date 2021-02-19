<?php


namespace Yan9\Orderforys\Cores;


use GuzzleHttp\Client;

class YouShuHttpUtil
{
    public static function get(string $url)
    {
        $httpClient = new Client([
            'timeout'  => 10,
            'verify'   => false,
        ]);

        $res = $httpClient->request('get', $url);

        if ($res instanceof \Psr\Http\Message\ResponseInterface) {
            $body = $res->getBody();
        }

        if (empty($body)) {
            return false;
        }
        $status = $res->getStatusCode();
        $contents = $body->getContents();

        $res_youshu = json_decode($contents, true);

        if(intval($status)==200 && JSON_ERROR_NONE === json_last_error()){
            return $res_youshu;
        }else{
            return false;
        }
    }

    public static function post(string $url, array $params = [], $type = 'json')
    {
        $httpClient = new Client([
            'timeout'  => 10,
            'verify'   => false,
        ]);

        if ($type == 'json') {
            $res = $httpClient->request('post', $url, ['json' => $params]);
        } else {
            $res = $httpClient->request('post', $url, ['form_params' => $params]);
        }

        if ($res instanceof \Psr\Http\Message\ResponseInterface) {
            $body = $res->getBody();
        }

        if (empty($body)) {
            return false;
        }
        $status = $res->getStatusCode();
        $contents = $body->getContents();

        $res_youshu = json_decode($contents, true);

        if(intval($status)==200 && JSON_ERROR_NONE === json_last_error()){
            return $res_youshu;
        }else{
            return false;
        }
    }

    public static function mini_post(string $url, array $params = [])
    {
        $httpClient = new Client([
            'timeout'  => 10,
            'verify'   => false,
        ]);

        $res = $httpClient->request('post', $url, ['json' => $params]);

        if ($res instanceof \Psr\Http\Message\ResponseInterface) {
            $body = $res->getBody();
        }

        if (empty($body)) {
            return false;
        }
        $status = $res->getStatusCode();
        $contents = $body->getContents();

        $res_youshu = json_decode($contents, true);

        if(intval($status)==200 && JSON_ERROR_NONE === json_last_error()){
            return $res_youshu;
        }else{
            return false;
        }
    }
}
