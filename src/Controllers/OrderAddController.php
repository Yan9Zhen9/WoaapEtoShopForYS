<?php

namespace Yan9\Orderforys\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yan9\Orderforys\Controllers\Orders\Order;
use Yan9\Orderforys\Cores\SignService;
use Yan9\Orderforys\Cores\ToolUtil;
use Yan9\Orderforys\Cores\YouShuHttpUtil;
use Yan9\Orderforys\Cores\YsConfig;

/**
 * 添加订单
 * Class OrderAddController
 * @package Yan9\Orderforys\Controllers
 */
class OrderAddController extends Controller
{
    const URL_ADD_ORDER = 'order_add';

    private $ysConfig;

    public function __construct()
    {
        $this->ysConfig   = new YsConfig();
    }

    /**
     * Action:添加订单
     * @param $order_info //订单信息
     * @param $node //时间节点
     * @param $dataSourceId //数据仓库ID
     * @param $type //类型
     * @return array|bool|mixed
     *
     * Date: 2021/3/1
     */
    public function add($order_info, $node, $dataSourceId, $type)
    {
        try {
            $url = $this->ysConfig->getUrl(self::URL_ADD_ORDER);
            $params['dataSourceId'] = $dataSourceId;
            $params['orders'][] = (new Order($type))->getOrders($order_info, $node);
            return YouShuHttpUtil::post($url, $params);
        } catch (\Exception $exception) {
            return ToolUtil::errorResponse($exception->getMessage());
        }
    }
}
