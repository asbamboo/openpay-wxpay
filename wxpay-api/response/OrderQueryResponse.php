<?php
namespace asbamboo\openpayWxpay\wxpayApi\response;

/**
 * 查询订单 响应结果
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月19日
 */
class OrderQueryResponse extends ResponseAbstract
{
    /**
     * 设备号 如（013467007045764）
     * 可选
     * 微信支付分配的终端设备号，
     *
     * @var string(32)
     */
    public $device_info;

    /**
     * 用户标识 如（oUpF8uMuAJO_M2pxb1Q9zNjWeS6o）
     * 必填
     * 用户在商户appid下的唯一标识
     *
     * @var string(128)
     */
    public $openid;

    /**
     * 是否关注公众账号 如（Y）
     * 必填
     * 用户是否关注公众账号，Y-关注，N-未关注
     *
     * @var string(1)
     */
    public $is_subscribe;

    /**
     * 交易类型 如（APP）
     * 必填
     * 调用接口提交的交易类型
     *
     * @var string(16)
     */
    public $trade_type;

    /**
     * 交易状态 如（SUCCESS）
     * 必填
     * 交易状态
     *  - SUCCESS—支付成功
     *  - REFUND—转入退款
     *  - NOTPAY—未支付
     *  - CLOSED—已关闭
     *  - REVOKED—已撤销（刷卡支付）
     *  - USERPAYING--用户支付中
     *  - PAYERROR--支付失败(其他原因，如银行返回失败)
     *
     * @var string(32)
     */
    public $trade_state;

    /**
     * 付款银行 如（CMC）
     * 必填
     * 银行类型，采用字符串类型的银行标识
     *
     * @var string(16)
     */
    public $bank_type;

    /**
     * 总金额 如（100）
     * 必填
     * 订单总金额，单位为分
     *
     * @var int
     */
    public $total_fee;

    /**
     * 货币种类 如（CNY）
     * 可选
     * 货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     *
     * @var string(8)
     */
    public $fee_type;

    /**
     * 现金支付金额 如（100）
     * 必填
     * 现金支付金额订单现金支付金额，详见支付金额
     *
     * @var int
     */
    public $cash_fee;

    /**
     * 现金支付货币类型 如（CNY）
     * 可选
     * 货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     *
     * @var string(16)
     */
    public $cash_fee_type;

    /**
     * 应结订单金额 如（100）
     * 可选
     * 当订单使用了免充值型优惠券后返回该参数，应结订单金额=订单金额-免充值优惠券金额。
     *
     * @var int
     */
    public $settlement_total_fee;

    /**
     * 代金券金额 如（100）
     * 可选
     * “代金券或立减优惠”金额<=订单总金额，订单总金额-“代金券或立减优惠”金额=现金支付金额，详见支付金额
     *
     * @var int
     */
    public $coupon_fee;

    /**
     * 代金券使用数量 如（1）
     * 可选
     * 代金券或立减优惠使用数量
     *
     * @var int
     */
    public $coupon_count;

    /**
     * 代金券使用数量 如（10000）
     * 可选
     * 代金券或立减优惠ID, $n为下标，从0开始编号
     *
     * $coupon_id_$n
     *
     * @var string(20)
     */
    public $coupon_id;

    /**
     * 代金券类型 如（CASH）
     * 可选
     *  - CASH--充值代金券
     *  - NO_CASH---非充值优惠券
     *
     * 开通免充值券功能，并且订单使用了优惠券后有返回（取值：CASH、NO_CASH）。$n为下标,从0开始编号，举例：coupon_type_$0
     *
     * coupon_type_$n
     *
     * @var string
     */
    public $coupon_type;

    /**
     * 单个代金券支付金额 如（100）
     * 可选
     * 单个代金券或立减优惠支付金额, $n为下标，从0开始编号
     *
     * coupon_fee_$n
     *
     * @var int
     */
    public $coupon_fee;

    /**
     * 微信支付订单号 如（1009660380201506130728806387）
     * 必填
     * 微信支付订单号
     *
     * coupon_fee_$n
     *
     * @var string(32)
     */
    public $transaction_id;

    /**
     * 商户订单号 如（20150806125346）
     * 必填
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     *
     * @var string(32)
     */
    public $out_trade_no;

    /**
     * 附加数据 如（深圳分店）
     * 可选
     * 附加数据，原样返回
     *
     * @var string(128)
     */
    public $attach;

    /**
     * 支付完成时间 如（20141030133525）
     * 必填
     * 订单支付时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010。其他详见时间规则
     *
     * @var string(14)
     */
    public $time_end;


    /**
     * 交易状态描述 如（20141030133525）
     * 必填
     * 支付失败，请重新下单支付	对当前查询订单状态的描述和下一步操作的指引
     *
     * @var string(256)
     */
    public $trade_state_desc;
}