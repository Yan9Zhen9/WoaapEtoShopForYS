<?php


namespace Yan9\Orderforys\Utils;


class YsConfig
{
    private $appId;
    private $appSecret;
    private $merchantId;

    public function __construct()
    {
        $this->appId = $this->getAppId();
        $this->appSecret = $this->getAppSecret();
        $this->merchantId = $this->getMerchantId();
    }

    public function getAppId()
    {
        $appId = config('orderforys')['app_id'] ?? '';
        if (empty($appId)) {
            throw new \Exception('app_id 未配置');
        }
        return $appId;
    }

    public function getAppSecret()
    {
        $appSecret = config('orderforys')['app_secret'] ?? '';
        if (empty($appSecret)) {
            throw new \Exception('app_secret 未配置');
        }
        return $appSecret;
    }

    public function getMerchantId()
    {
        $merchantId = config('orderforys')['merchant_id'] ?? '';
        if (empty($merchantId)) {
            throw new \Exception('merchant_id 未配置');
        }
        return $merchantId;
    }

    public function getUrl($type)
    {
        try {
            $params = SignService::getUrlSing($this->appId, $this->appSecret);
            return config('orderforys')['ys_domain'] . config('orderforys')['url_list'][$type] . '?' . $params;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getDataSourceUrl($dataSourceType)
    {
        try {
            $params = SignService::getUrlSing($this->appId, $this->appSecret);
            return config('orderforys')['ys_domain'] . config('orderforys')['url_list']['data_source_get'] .
                '?dataSourceType=' . $dataSourceType . '&merchantId=' . $this->merchantId . '&' . $params;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
