<?php

namespace Yan9\Orderforys\Cores;


use Yan9\Orderforys\Utils\ToolUtil;
use Yan9\Orderforys\Utils\YouShuHttpUtil;
use Yan9\Orderforys\Utils\YsConfig;

/**
 * 数据仓库处理类
 * Class DataSource
 * @package Yan9\Orderforys\Cores
 */
class DataSource
{
    const URL_ADD_DATA_SOURCE = 'data_source_add';//添加数据仓库
    const URL_GET_DATA_SOURCE = 'data_source_get';//获取数据仓库

    private $ysConfig;

    public function __construct()
    {
        $this->ysConfig = new YsConfig();
    }

    /**
     * Action:添加数据仓库
     * @param $dataSourceType
     * @return array|bool|mixed
     *
     * Date: 2021/2/26
     */
    public function addDataSource($dataSourceType)
    {
        try {
            if (empty($dataSourceType) && $dataSourceType != 0) {
                throw new \Exception('dataSourceType 不能为空');
            }
            $url = $this->ysConfig->getUrl(self::URL_ADD_DATA_SOURCE);
            $params = [
                'merchantId' => $this->ysConfig->getMerchantId(),
                'dataSourceType' => (int)$dataSourceType
            ];
            return YouShuHttpUtil::post($url, $params);
        } catch (\Exception $exception) {
            return ToolUtil::errorResponse($exception->getMessage());
        }
    }

    /**
     * Action:获取数据仓库
     * @param $dataSourceType
     * @return array|bool|mixed
     *
     * Date: 2021/2/26
     */
    public function getDataSource($dataSourceType) {
        try {
            if (empty($dataSourceType) && $dataSourceType != 0) {
                throw new \Exception('dataSourceType 不能为空');
            }
            $url = $this->ysConfig->getDataSourceUrl($dataSourceType);
            return YouShuHttpUtil::get($url);
        } catch (\Exception $exception) {
            return ToolUtil::errorResponse($exception->getMessage());
        }
    }

    /**
     * Action:添加数据仓库(新版本,取消仓库类型)
     * @return array|bool|mixed
     *
     * Date: 2021/5/11
     */
    public function addNewDataSource() {
        try {
            $url = $this->ysConfig->getUrl(self::URL_ADD_DATA_SOURCE);
            $params = [
                'merchantId' => $this->ysConfig->getMerchantId(),
            ];
            return YouShuHttpUtil::post($url, $params);
        } catch (\Exception $exception) {
            return ToolUtil::errorResponse($exception->getMessage());
        }
    }

    /**
     * Action:获取数据仓库(新版本,取消仓库类型)
     * @return array|bool|mixed
     *
     * Date: 2021/5/11
     */
    public function getNewDataSource() {
        try {
            $url = $this->ysConfig->getUrl(self::URL_GET_DATA_SOURCE);
            return YouShuHttpUtil::get($url);
        } catch (\Exception $exception) {
            return ToolUtil::errorResponse($exception->getMessage());
        }
    }
}
