<?php
namespace asbamboo\openpayWxpay\wxpayApi\requestParams\unit;

use asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParams;

/**
 * 查询订单 请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月19日
 */
class OrderQueryParams extends RequestParams
{
    /**
     * 微信订单号 如(1009660380201506130728806387)
     * transaction_id与out_trade_no两个里面必须一个有值优先transaction_id
     *
     * @var string(32)
     */
    public $transaction_id;

    /**
     * 商户订单号 如(20150806125346)
     * 商户系统内部的订单号，当没提供transaction_id时需要传这个。
     *
     * @var string(32)
     */
    public $out_trade_no;
}