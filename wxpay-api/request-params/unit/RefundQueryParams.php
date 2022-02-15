<?php
namespace asbamboo\openpayWxpay\wxpayApi\requestParams\unit;

use asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParams;

/**
 * 申请退款 请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class RefundQueryParams extends RequestParams
{
    /**
     * 微信订单号 如(1217752501201407033233368018)
     * transaction_id与out_trade_no,out_refund_no,refund_id四选一
     * 微信生成的订单号，在支付通知中有返回
     *
     * @var string(32)
     */
    public $transaction_id;

    /**
     * 商户订单号 如（1217752501201407033233368018）
     * transaction_id与out_trade_no,out_refund_no,refund_id四选一
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     *
     * @var string(32)
     */
    public $out_trade_no;

    /**
     * 商户退款单号 如（1217752501201407033233368018）
     * transaction_id与out_trade_no,out_refund_no,refund_id四选一
     * 商户系统内部的退款单号，商户系统内部唯一，只能是数字、大小写字母_-|*@ ，同一退款单号多次请求只退一笔。
     *
     * @var string(64)
     */
    public $out_refund_no;

    /**
     * 微信退款单号 如（1217752501201407033233368018）
     * transaction_id与out_trade_no,out_refund_no,refund_id四选一
     * 微信生成的退款单号，在申请退款接口有返回
     *
     * @var string(32)
     */
    public $refund_id;
    
    /**
     * 偏移量	 (如: 15)
     * 偏移量，当部分退款次数超过10次时可使用，表示返回的查询结果从这个偏移量开始取记录
     * @var Int
     */
    public $offset;
}