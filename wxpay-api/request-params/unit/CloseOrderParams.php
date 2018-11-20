<?php
namespace asbamboo\openpayWxpay\wxpayApi\requestParams\unit;

use asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParams;

/**
 * 关闭订单 请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class CloseOrderParams extends RequestParams
{
    /**
     * 商户订单号 如（1217752501201407033233368018	）
     * 必填
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     *
     * @var string(32)
     */
    public $out_trade_no;
}