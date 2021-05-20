<?php

namespace Yan9\Orderforys\Cores;

use Yan9\Orderforys\Utils\ToolUtil;
use Yan9\Orderforys\Utils\YouShuHttpUtil;
use Yan9\Orderforys\Utils\YsConfig;

/**
 * 汇总订单
 * Class AddOrderSum
 * @package Yan9\Orderforys\Cores
 */
class AddOrderSum
{
    const URL_ADD_ORDER_SUM = 'add_order_sum';

    private $ysConfig;

    public function __construct()
    {
        $this->ysConfig = new YsConfig();
    }

    /**
     * Action:汇总订单
     * @param $orderSum
     * @param $dataSourceId
     * @return array|bool|mixed
     *
     * Date: 2021/5/11
     */
    public function AddOrderSum($orderSum, $dataSourceId)
    {
        try {
            if (empty($orderSum)) {
                throw new \Exception('orderSum 不能为空');
            }
            if (empty($dataSourceId)) {
                throw new \Exception('dataSourceId 不能为空');
            }
            $url = $this->ysConfig->getUrl(self::URL_ADD_ORDER_SUM);
            $params['dataSourceId'] = $dataSourceId;
            $params['orders'] = $orderSum;
            return YouShuHttpUtil::post($url, $params);
        } catch (\Exception $exception) {
           return ToolUtil::errorResponse($exception->getMessage());
        }
    }
}
