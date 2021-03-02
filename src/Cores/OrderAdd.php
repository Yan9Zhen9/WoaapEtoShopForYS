<?php

namespace Yan9\Orderforys\Cores;

use Yan9\Orderforys\Cores\Orders\Order;
use Yan9\Orderforys\Utils\ToolUtil;
use Yan9\Orderforys\Utils\YouShuHttpUtil;
use Yan9\Orderforys\Utils\YsConfig;

/**
 * 添加订单
 * Class OrderAdd
 * @package Yan9\Orderforys\Cores
 */
class OrderAdd
{
    const URL_ADD_ORDER = 'order_add';

    private $ysConfig;

    public function __construct()
    {
        $this->ysConfig = new YsConfig();
    }

    /**
     * Action:添加订单
     * @param $orderInfo //订单信息
     * @param $node //时间节点
     * @param $dataSourceId //数据仓库ID
     * @param $type //类型
     * @return array|bool|mixed
     *
     * Date: 2021/3/1
     */
    public function add($orderInfo, $node, $dataSourceId, $type)
    {
        try {
            $url = $this->ysConfig->getUrl(self::URL_ADD_ORDER);
            $params['dataSourceId'] = $dataSourceId;
            $params['orders'][] = (new Order($type))->getOrders($orderInfo, $node);
            return YouShuHttpUtil::post($url, $params);
        } catch (\Exception $exception) {
            return ToolUtil::errorResponse($exception->getMessage());
        }
    }
}
