<?php


namespace Yan9\Orderforys;


use Yan9\Orderforys\Controllers\AddVisitPageController;
use Yan9\Orderforys\Controllers\DataSourceController;
use Yan9\Orderforys\Controllers\OrderAddController;

class YsClient
{
    private $addVisitPage;
    private $dataSource;
    private $orderAdd;

    public function __construct()
    {
        $this->addVisitPage = new AddVisitPageController();
        $this->dataSource   = new DataSourceController();
        $this->orderAdd     = new OrderAddController();
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
    public function addOrder($order_info, $node, $dataSourceId, $type = 0)
    {
        return $this->orderAdd->add($order_info, $node, $dataSourceId, $type);
    }

    /**
     * Action:微信页面上报
     * @param $rawMsg //微信小程序后台请求结果列表
     * @param $dataSourceId //数据仓库ID
     * @return array|bool|mixed
     *
     * Date: 2021/3/1
     */
    public function addVisitPage($rawMsg, $dataSourceId)
    {
        return $this->addVisitPage->addVisitPage($rawMsg, $dataSourceId);
    }

    /**
     * Action:添加数据仓库
     * @param $dataSourceType //仓库类型
     * @return array|bool|mixed
     *
     * Date: 2021/2/26
     */
    public function addDataSource($dataSourceType)
    {
        return $this->dataSource->addDataSource($dataSourceType);
    }

    /**
     * Action:获取数据仓库
     * @param $dataSourceType //仓库类型
     * @return array|bool|mixed
     *
     * Date: 2021/2/26
     */
    public function getDataSource($dataSourceType)
    {
        return $this->dataSource->getDataSource($dataSourceType);
    }
}
