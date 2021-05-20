# yan9/orderforys

Laravel package

- 安装后执行命令 `php artisan vendor:publish --provider="Yan9\Orderforys\OrderforysServiceProvider"`

- 配置 config/orderforys.php

- 修改配置文件后要使用命令 `php artisan config:clear` 清除一下！

使用

- 配置config/orderforys.php到env
~~~
.env :

YS_APP_ID=   //appId
YS_APP_SECRET=  //appSecret
YS_MERCHANT_ID=  //商家id，有数提供
~~~

- 使用时实例化YsClient类即可 (目前只支持添加订单,添加数据仓库,获取数据仓库,微信上报页面访问)

例：

1> 添加订单
~~~

$ys = new YsClient(); //实例化

/**
 * Action:添加订单
 * $orderInfo //订单信息
 * $node //事件节点（创单成功:order_create_success,
 *                  支付成功:order_pay_success,
 *                  发货:order_deliver,
 *                  订单完成:order_success,
 *                  退货完成:refund_success）
 * $dataSourceId //数据仓库ID(可通过获取数据仓库方法获取)
 * $type //版本类型(因为会存在多个订单信息的版本)
 * @return array|bool|mixed
 */
$ys->addOrder($orderInfo, $node, $dataSourceId, $type);

~~~
~~~
应答示例:
{
  "retcode":0,
  "errmsg":"",
  "data": {}
}
~~~

2> 添加数据仓库
~~~

$ys = new YsClient(); //实例化

/**
 * Action:添加数据仓库(每个接口创建一个数据仓库后，传输数据可重复使用。每种数据源类型的数据仓库只可添加一次。每个接口创建一个数据仓库后，传输数据时可重复使用。)
 * @param $dataSourceType //仓库类型(具体如下：添加数据仓库)
 * @return array|bool|mixed
 */
$ys->addDataSource($dataSourceType);

~~~
[添加数据仓库](https://mp.zhls.qq.com/youshu-docs/develop/interface/datawarehouse/data_source_add.html)
~~~
应答示例:
{
    "retcode": 0,
    "errmsg": "",
    "data": {
        "dataSource": {
            "id": "147",
            "type": 0,
            "merchantId": "1"
        }
    }
}
~~~

3> 获取数据仓库
~~~

$ys = new YsClient(); //实例化

/**
 * Action:获取数据仓库
 * @param $dataSourceType //仓库类型(具体如下：获取数据仓库)
 * @return array|bool|mixed  
 */
$ys->getDataSource($dataSourceType);

~~~
[获取数据仓库](https://mp.zhls.qq.com/youshu-docs/develop/interface/datawarehouse/data_source_get.html)
~~~
应答示例:
{
    "retcode": 0,
    "errmsg": "",
    "data": {
        "dataSources": [
            {
                "id": "147",
                "type": 0,
                "merchantId": "1"
            }
        ]
    }
}
~~~

4> 上报页面访问
~~~

$ys = new YsClient(); //实例化

/**
 * Action:微信上报页面访问
 * @param $rawMsg //微信小程序后台请求结果列表(具体如下：上报页面访问)
 * @param $dataSourceId //数据仓库ID
 * @return array|bool|mixed
 */
$ys->addVisitPage($rawMsg,$dataSourceType);

~~~
[上报页面访问](https://mp.zhls.qq.com/youshu-docs/develop/interface/wxapp/add_wxapp_page_visit.html)
~~~
应答示例:
{
  "retcode":0,
  "errmsg":"",
  "data": {}
}
~~~

5> 汇总订单
~~~

$ys = new YsClient(); //实例化

/**
     * Action:汇总订单
     * @param $orderSum =[  //订单列表 数组最大长度 50
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
     */
$ys->addOrderSum($orderSum, $dataSourceId);

~~~
~~~
应答示例:
{
  "retcode":0,
  "errmsg":"",
  "data": {}
}
~~~

6> 添加数据仓库（新版本）
~~~

$ys = new YsClient(); //实例化

/**
 * Action:添加数据仓库(新版本,取消仓库类型)
 * @return array|bool|mixed
 */
$ys->addNewDataSource();

~~~
~~~
应答示例:
{
    "retcode": 0,
    "errmsg": "",
    "data": {
        "dataSource": {
            "id": "147",
            "merchantId": "1"
        }
    }
}
~~~


7> 获取数据仓库（新版本）
~~~

$ys = new YsClient(); //实例化

/**
 * Action:获取数据仓库(新版本,取消仓库类型)
 * @return array|bool|mixed 
 */
$ys->getNewDataSource();

~~~
~~~
应答示例:
{
    "retcode": 0,
    "errmsg": "",
    "data": {
        "dataSources": [
            {
                "id": "147",  // dataSourceId
                "type": 0,  // 接口类型，自2021年4月29日后返回的 DataSourceId 不再有 type 值。
                "merchantId": "1"  // 商家 ID
            },
            {
                "id": "17",
                "merchantId": "1"
            }
        ]
    }
}
~~~



- 应答体字段

|  参数名  |   类型   |  描述  |
| :------ | :------ | :------  |
| retcode | integer |   返回码    |
| errmsg  | string  |   错误信息   |
| data    | json object |   响应内容  |
