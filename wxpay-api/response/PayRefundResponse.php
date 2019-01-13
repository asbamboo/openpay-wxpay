<?php
namespace asbamboo\openpayWxpay\wxpayApi\response;

/**
 * 申请退款 接口响应值
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class PayRefundResponse extends ResponseAbstract
{
    /**
     * 微信订单号 如（1217752501201407033233368018）
     * 必填
     * 微信订单号
     *
     * @var string(32)
     */
    private $transaction_id;

    /**
     * 商户订单号 如（1217752501201407033233368018）
     * 必填
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     *
     * @var string(32)
     */
    private $out_trade_no;

    /**
     * 商户退款单号 如（1217752501201407033233368018）
     * 必填
     * 商户系统内部的退款单号，商户系统内部唯一，只能是数字、大小写字母_-|*@ ，同一退款单号多次请求只退一笔。
     *
     * @var string(64)
     */
    private $out_refund_no;

    /**
     * 微信退款单号 如（1217752501201407033233368018）
     * 必填
     * 微信退款单号
     *
     * @var string(32)
     */
    private $refund_id;

    /**
     * 申请退款金额 如（100）
     * 必填
     * 退款总金额,单位为分,可以做部分退款
     *
     * @var int
     */
    private $refund_fee;

    /**
     * 退款金额 如（100）
     * 可选
     * 去掉非充值代金券退款金额后的退款金额，退款金额=申请退款金额-非充值代金券退款金额，退款金额<=申请退款金额
     *
     * @var int
     */
    private $settlement_refund_fee;

    /**
     * 订单金额 如（100）
     * 必填
     * 订单总金额，单位为分，只能为整数，详见支付金额
     *
     * @var int
     */
    private $total_fee;

    /**
     * 应结订单金额 如（100）
     * 可选
     * 应结订单金额=订单金额-免充值代金券金额，应结订单金额<=订单金额。
     *
     * @var int
     */
    private $settlement_total_fee;

    /**
     * 货币种类 如（CNY）
     * 可选
     * 订单金额货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     *
     * @var string(8)
     */
    private $fee_type;

    /**
     * 现金支付金额 如（100）
     * 必填
     * 现金支付金额，单位为分，只能为整数，详见支付金额
     *
     * @var int
     */
    private $cash_fee;

    /**
     * 现金退款金额 如（100）
     * 可选
     * 现金退款金额，单位为分，只能为整数，详见支付金额
     *
     * @var int
     */
    private $cash_refund_fee;

    /**
     * 代金券退款总金额 如（100）
     * 可选
     * 代金券退款金额<=退款金额，退款金额-代金券或立减优惠退款金额为现金，说明详见代金券或立减优惠
     *
     * @var int
     */
    private $coupon_refund_fee;

    /**
     * 退款代金券使用数量 如（1）
     * 可选
     * 退款代金券使用数量
     *
     * @var int
     */
    private $coupon_refund_count;

    /**
     * 代金券类型 如（CASH）
     * 可选
     * 退款代金券使用数量
     *  - CASH--充值代金券
     *  - NO_CASH---非充值代金券
     * 订单使用代金券时有返回（取值：CASH、NO_CASH）。$n为下标,从0开始编号，举例：coupon_type_0
     *
     * coupon_type_$n
     *
     * @var string(8)
     */
    private $coupon_type;

    /**
     * 退款代金券ID 如（10000）
     * 可选
     * 退款代金券ID, $n为下标，从0开始编号
     *
     * coupon_type_$n
     *
     * @var string(20)
     */
    private $coupon_type;

    /**
     * 单个代金券退款金额 如（100）
     * 可选
     * 单个退款代金券支付金额, $n为下标，从0开始编号
     *
     * coupon_refund_fee_$n
     *
     * @var int
     */
    private $coupon_refund_fee;
}
