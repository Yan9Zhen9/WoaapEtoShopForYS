<?php


namespace Yan9\Orderforys;


use Yan9\Orderforys\Cores\AddOrderSum;
use Yan9\Orderforys\Cores\AddVisitPage;
use Yan9\Orderforys\Cores\DataSource;
use Yan9\Orderforys\Cores\OrderAdd;

class YsClient
{
    private $addVisitPage;
    private $dataSource;
    private $orderAdd;
    private $addOrderSum;

    public function __construct()
    {
        $this->addVisitPage = new AddVisitPage();
        $this->dataSource   = new DataSource();
        $this->orderAdd     = new OrderAdd();
        $this->addOrderSum  = new AddOrderSum();
    }

    /**
     * Action:添加订单
     * @param $orderInfo //订单信息
     * @param $node //事件节点
     * @param $dataSourceId //数据仓库ID
     * @param $type //类型
     * @return array|bool|mixed
     *
     * Date: 2021/3/1
     */
    public function addOrder($orderInfo, $node, $dataSourceId, $type = 0)
    {
        return $this->orderAdd->add($orderInfo, $node, $dataSourceId, $type);
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

    /**
     * Action:汇总订单
     * @param $orderSum = [  //订单列表 数组最大长度 50
     *   [
     *    "ref_date"              => '日期，unix时间戳，字段长度为13字节',
     *    "give_order_amount_sum" => '该日期的下单金额之和',
     *    "give_order_num_sum"    => '该日期的下单数量之和',
     *    "payment_amount_sum"    => '该日期的支付金额之和',
     *    "payed_num_sum"         => '该日期的支付数量之和',
     *   ],
     * ]
     * @param $dataSourceId //数据仓库ID
     * @return array|bool|mixed
     *
     * Date: 2021/5/11
     */
    public function addOrderSum($orderSum, $dataSourceId)
    {
        return $this->addOrderSum->addOrderSum($orderSum, $dataSourceId);
    }

    /**
     * Action:添加数据仓库(新版本,取消仓库类型)
     * @return array|bool|mixed
     *
     * Date: 2021/5/11
     */
    public function addNewDataSource()
    {
        return $this->dataSource->addNewDataSource();
    }

    /**
     * Action:获取数据仓库(新版本,取消仓库类型)
     * @return array|bool|mixed
     *
     * Date: 2021/5/11
     */
    public function getNewDataSource()
    {
        return $this->dataSource->getNewDataSource();
    }
}
