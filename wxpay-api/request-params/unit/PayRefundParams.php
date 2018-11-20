<?php
namespace asbamboo\openpayWxpay\wxpayApi\requestParams\unit;

use asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParams;

/**
 * 申请退款 请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class PayRefundParams extends RequestParams
{
    /**
     * 微信订单号 如(1217752501201407033233368018)
     * transaction_id与out_trade_no二选一
     * 微信生成的订单号，在支付通知中有返回
     *
     * @var string(32)
     */
    public $transaction_id;

    /**
     * 商户订单号 如（1217752501201407033233368018）
     * transaction_id与out_trade_no二选一
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     *
     * @var string(32)
     */
    public $out_trade_no;

    /**
     * 商户退款单号 如（1217752501201407033233368018）
     * 必填
     * 商户系统内部的退款单号，商户系统内部唯一，只能是数字、大小写字母_-|*@ ，同一退款单号多次请求只退一笔。
     *
     * @var string(64)
     */
    public $out_refund_no;

    /**
     * 订单金额 如（100）
     * 必填
     * 订单总金额，单位为分，只能为整数，详见支付金额
     *
     * @var int
     */
    public $total_fee;

    /**
     * 退款金额 如（100）
     * 必填
     * 退款总金额，订单总金额，单位为分，只能为整数，详见支付金额
     *
     * @var int
     */
    public $refund_fee;

    /**
     * 退款货币种类 如（CNY）
     * 可选
     * 退款货币类型，需与支付一致，或者不填。符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     *
     * @var string(8)
     */
    public $refund_fee_type;

    /**
     * 退款原因 如（商品已售完）
     * 可选
     * 若商户传入，会在下发给用户的退款消息中体现退款原因
     *
     * @var string(80)
     */
    public $refund_desc;

    /**
     * 退款资金来源 如（REFUND_SOURCE_RECHARGE_FUNDS）
     * 可选
     * 仅针对老资金流商户使用
     *  - REFUND_SOURCE_UNSETTLED_FUNDS -- 未结算资金退款（默认使用未结算资金退款）
     *  - REFUND_SOURCE_RECHARGE_FUNDS---可用余额退款
     *
     * @var string(30)
     */
    public $refund_account;

    /**
     * 退款结果通知url 如（https://weixin.qq.com/notify/）
     * 可选
     * 异步接收微信支付退款结果通知的回调地址，通知URL必须为外网可访问的url，不允许带参数
     * 如果参数中传了notify_url，则商户平台上配置的回调地址将不会生效。
     *
     * @var string(256)
     */
    public $notify_url;
}