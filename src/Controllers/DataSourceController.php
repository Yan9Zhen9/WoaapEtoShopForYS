<?php

namespace Yan9\Orderforys\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yan9\Orderforys\Cores\SignService;
use Yan9\Orderforys\Cores\ToolUtil;
use Yan9\Orderforys\Cores\YouShuHttpUtil;
use Yan9\Orderforys\Cores\YsConfig;

/**
 * 数据仓库处理类
 * Class DataSourceController
 * @package Yan9\Orderforys\Controllers
 */
class DataSourceController extends Controller
{
    const URL_ADD_DATA_SOURCE = 'data_source_add';//添加数据仓库

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
            return YouShuHttpUtil::post($url, $params);
        } catch (\Exception $exception) {
            return ToolUtil::errorResponse($exception->getMessage());
        }
    }
}
