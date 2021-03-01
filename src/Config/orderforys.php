<?php
switch (env('APP_ENV')) {
    case 'production':
        $ys_domain = 'https://zhls.qq.com/';
        break;
    default:
        $ys_domain = 'https://test.zhls.qq.com/';
        break;
}

$url_list = [
    /** ------  数据仓库接口  ------ **/
    'data_source_add'      => 'data-api/v1/data_source/add', //添加数据仓库
    'data_source_get'      => 'data-api/v1/data_source/get', //获取数据仓库
    /** ------  订单接口  ------ **/
    'order_add'            => 'data-api/v1/order/add_order', //添加/更新订单
    'order_update'         => 'data-api/v1/order/update', //订单状态变更
    'return_order_add'     => 'data-api/v1/return_order/add', //退货退款订单添加
    'add_order_sum'        => 'data-api/v1/order/add_order_sum', //汇总订单接口
    /** ------  微信数据上报接口  ------ **/
    'add_wxapp_visit_page' => 'data-api/v1/analysis/add_wxapp_visit_page', //上报页面访问
];

return [
    'ys_domain'   => $ys_domain,
    'app_id'      => env('YS_APP_ID'),
    'app_secret'  => env('YS_APP_SECRET'),
    'merchant_id' => env('YS_MERCHANT_ID'),
];
