<?php

namespace Yan9\Orderforys\Controllers\Orders;

class OrderInfo
{
    /**
     * Action:根据订单状态获取对应的构造数据
     * @param $data
     * @param $order_status
     * @return array
     */
    public function getOrders($data, $order_status)
    {
        $result = [];
        switch ($order_status) {
            // 主订单状态，1110待支付，1150已支付待发货，1160已发货，1180销售完成/已收货，1280退款中，1290退货完成
            case 'order_create_success':
                $result = self::createUnPaySuccessOrder($data);
                break;
            case 'order_pay_success':
                $result = self::createPaySuccessOrder($data);
                break;
            case 'order_deliver':
                $result = self::createDeliverySuccessOrder($data);
                break;
            case 'order_success':
                $result = self::createReceiveSuccessOrder($data);
                break;
            case 'refund_success':
                $result = self::createRefundSuccessOrder($data);
                break;
        }
        return $result;
    }

    /**
     * Action:获取未支付订单参数
     * @param $data
     * @return array
     */
    private static function createUnPaySuccessOrder($data)
    {
        $list = self::_makeCommonDataPay($data);//获取公共参数
        $list['order_status'] = '1110';
        return $list;
    }

    /**
     * Action:获取支付成功订单参数
     * @param $data
     * @return array
     */
    private static function createPaySuccessOrder($data)
    {
        $list = self::_makeCommonDataPay($data);//获取公共参数
        $list['order_status'] = '1150';
        $paymentInfo[] = [
            'payment_type' => '00009',//微信支付
            'trans_id' => $data['transaction_id'] ?? '',//微信支付订单ID/流水号
            'trans_amount' => (float)sprintf('%.2f', $data['pay_price']),
        ];//主订单每种支付方式的支付信息,order_status = 1110时 payment_info非必填，其他状态码必填
        $list['payment_info'] = $paymentInfo;
        return $list;
    }

    /**
     * Action:获取已发货订单参数
     * @param $data
     * @return array
     */
    private static function createDeliverySuccessOrder($data)
    {
        $list = self::_makeCommonDataDeliver($data);//获取公共参数
        $list['order_status'] = '1160';
        $paymentInfo[] = [
            'payment_type' => '00009',//微信支付
            'trans_id' => $data['order_info']['wechat_order_no'] ?? $data['order_info']['order_no'],//微信支付订单ID/流水号
            'trans_amount' => (float)sprintf('%.2f', $data['order_info']['pay_price']),
        ];
        $list['payment_info'] = $paymentInfo;
        return $list;
    }

    /**
     * Action:获取已收货订单参数
     * @param $data
     * @return array
     */
    private static function createReceiveSuccessOrder($data)
    {
        $list = self::_makeCommonDataDeliver($data);//获取公共参数
        $list['order_status'] = '1180';
        $paymentInfo[] = [
            'payment_type' => '00009',//微信支付
            'trans_id' => $data['order_info']['wechat_order_no'] ?? $data['order_info']['order_no'],//微信支付订单ID/流水号
            'trans_amount' => (float)sprintf('%.2f', $data['order_info']['pay_price']),
        ];
        $list['payment_info'] = $paymentInfo;
        return $list;
    }

    /**
     * Action:构造公共参数(创单/支付单)
     * @param $data
     * @return array
     */
    private static function _makeCommonDataPay($data)
    {
        $goodsInfo = [];
        $goods_amount_total = 0.00;
        foreach ($data['goods_info'] as $goods) {//构造商品信息
            $goodsInfo[] = [
                'external_sku_id' => $goods['shop_sku'],
                'sku_name_chinese' => $goods['product_name'],
                'goods_amount' => (float)sprintf('%.2f', bcdiv($goods['sell_price'], $goods['product_num'], 2)),
                'payment_amount' => (float)sprintf('%.2f', $goods['pay_price']),
                'is_gift' => $goods['type'] == 2 ? 1 : 0,
                'external_spu_id' => $goods['product_spu'],
                'spu_name_chinese' => $goods['product_name'],
                'goods_num' => (int)$goods['product_num']
            ];
            $goods_amount_total += (float)sprintf('%.2f', $goods['sell_price']);
        }

        $freight_amount = $data['fee_price'] == 0 ? 0.00 : sprintf('%.2f', $data['fee_price']);//订单运费，单位默认为元 注：运费为0时，传0.00
        return [
            'external_order_id' => $data['order_no'],
            'create_time' => bcmul(strtotime($data['create_time']), 1000),
            'order_source' => 'wxapp',
            'order_type' => 1,
            'brand_name' => $data['brand_name'],
            'goods_num_total' => (int)$data['product_num'],
            'goods_amount_total' => $goods_amount_total,
            'freight_amount' => (float)$freight_amount,
            'order_amount' => (float)bcadd($goods_amount_total, $freight_amount, 2),//订单金额，单位默认为元 注：商品总金额+运费金额=订单金额
            'payable_amount' => (float)sprintf('%.2f', $data['pay_price']),//订单应付金额
            'payment_amount' => (float)sprintf('%.2f', $data['pay_price']),//实付金额
            'user_info' => [
                'open_id' => $data['openid'],
                'union_id' => $data['unionid'],
                'app_id' => $data['wechat_app_id'] ?? '',
            ],
            'goods_info' => $goodsInfo,
            'is_deleted' => 0,
        ];
    }

    /**
     * Action:构造参数(发货/确认收货)
     * @param $data
     * @return array
     */
    private static function _makeCommonDataDeliver($data)
    {
        $goodsInfo = [];
        $goods_amount_total = 0.00;
        foreach ($data['order_goods'] as $goods) {//构造商品信息
            $goodsInfo[] = [
                'external_sku_id' => $goods['shop_sku'],
                'sku_name_chinese' => $goods['product_name'],
                'goods_amount' => (float)sprintf('%.2f', bcdiv($goods['sell_price'], $goods['product_number'], 2)),
                'payment_amount' => (float)sprintf('%.2f', $goods['pay_price']),
                'is_gift' => $goods['type'] == 2 ? 1 : 0,
                'external_spu_id' => $goods['product_spu'],
                'spu_name_chinese' => $goods['product_name'],
                'goods_num' => (int)$goods['product_number']
            ];
            $goods_amount_total += (float)sprintf('%.2f', $goods['sell_price']);
        }

        $freight_amount = $data['order_info']['fee_price'] == 0 ? 0.00 : sprintf('%.2f', $data['order_info']['fee_price']);//订单运费，单位默认为元 注：运费为0时，传0.00
        return [
            'external_order_id' => $data['order_info']['order_no'],
            'create_time' => bcmul(strtotime($data['order_info']['create_time']), 1000),
            'order_source' => 'wxapp',
            'order_type' => 1,
            'brand_name' => $data['brand_name'],
            'goods_num_total' => (int)$data['order_info']['goods_num'],
            'goods_amount_total' => $goods_amount_total,
            'freight_amount' => (float)$freight_amount,
            'order_amount' => (float)bcadd($goods_amount_total, $freight_amount, 2),//订单金额，单位默认为元 注：商品总金额+运费金额=订单金额
            'payable_amount' => (float)sprintf('%.2f', $data['order_info']['pay_price']),//订单应付金额
            'payment_amount' => (float)sprintf('%.2f', $data['order_info']['pay_price']),//实付金额
            'user_info' => [
                'open_id' => $data['order_info']['openid'],
                'union_id' => $data['order_info']['unionid'],
                'app_id' => $data['wechat_app_id'] ?? '',
            ],
            'goods_info' => $goodsInfo,
            'is_deleted' => 0,
        ];
    }

    /**
     * Action:构造参数(退款成功)
     * @param $data
     * @return array
     */
    private static function createRefundSuccessOrder($data)
    {
        $goodsInfo = [];
        $goods_amount_total = 0.00;
        foreach ($data['goods_info'] as $goods) {
            $goodsInfo[] = [
                'external_sku_id' => $goods['shop_sku'],
                'sku_name_chinese' => $goods['goods_name'],
                'goods_amount' => (float)bcdiv($goods['sell_price'], $goods['goods_num'], 0),
                'payment_amount' => (float)$goods['pay_price'],
                'external_spu_id' => $goods['product_spu'],
                'spu_name_chinese' => $goods['goods_name'],
                'goods_num' => (int)$goods['goods_num']
            ];
            $goods_amount_total += $goods['sell_price'];
        }

        $paymentInfo[] = [
            'payment_type' => '00009',
            'trans_id' => $data['transaction_id'] ?? $data['order_no'],
            'trans_amount' => (float)$data['real_price'],
        ];

        return [
            'external_order_id' => $data['order_no'],
            'create_time' => bcmul(strtotime($data['refund_time']), 1000),
            'order_source' => 'wxapp',
            'order_type' => 1,
            'brand_name' => $data['brand_name'],
            'goods_num_total' => (int)$data['goods_num'],
            'goods_amount_total' => (float)$goods_amount_total,
            'freight_amount' => (float)$data['fee_price'],
            'order_amount' => (float)bcadd($goods_amount_total, $data['fee_price'], 2),
            'payable_amount' => (float)$data['real_price'],
            'payment_amount' => (float)$data['real_price'],
            'order_status' => '1290',
            'user_info' => [
                'open_id' => $data['openid'],
                'union_id' => $data['unionid'],
                'app_id' => $data['wechat_app_id'] ?? '',
            ],
            'goods_info' => $goodsInfo,
            'payment_info' => $paymentInfo,
            'is_deleted' => 0,
        ];
    }
}
