<?php
namespace asbamboo\openpayWxpay\wxpayApi\response;

/**
 * 申请退款 接口响应值
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class RefundQueryResponse extends ResponseAbstract
{
    /**
     * 订单总退款次数	
     *  - 订单总共已发生的部分退款次数，当请求参数传入offset后有返回
     *  - 例如：35
     * @var Int
     */
    public $total_refund_count;
    
    /**
     * 微信订单号 如（1217752501201407033233368018）
     * 必填
     * 微信订单号
     *
     * @var string(32)
     */
    public $transaction_id;

    /**
     * 商户订单号 如（1217752501201407033233368018）
     * 必填
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     *
     * @var string(32)
     */
    public $out_trade_no;

    /**
     * 订单金额 如（100）
     * 必填
     * 订单总金额，单位为分，只能为整数，详见支付金额
     *
     * @var int
     */
    public $total_fee;
    
    /**
     * 应结订单金额 如（100）
     * 可选
     * 应结订单金额=订单金额-免充值代金券金额，应结订单金额<=订单金额。
     *
     * @var int
     */
    public $settlement_total_fee;
    
    /**
     * 货币种类 如（CNY）
     * 可选
     * 订单金额货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     *
     * @var string(8)
     */
    public $fee_type;
    
    /**
     * 现金支付金额 如（100）
     * 必填
     * 现金支付金额，单位为分，只能为整数，详见支付金额
     *
     * @var int
     */
    public $cash_fee;
    
    /**
     * 退款笔数	
     *  - 当前返回退款笔数
     * @var Int
     */
    public $refund_count;
    /**
     * 商户退款单号 如（1217752501201407033233368018）
     * 必填
     * 商户系统内部的退款单号，商户系统内部唯一，只能是数字、大小写字母_-|*@ ，同一退款单号多次请求只退一笔。
     * - 字段 out_refund_no_$n
     *
     * @var string(64)
     */
    public $out_refund_nos;

    /**
     * 微信退款单号 如（1217752501201407033233368018）
     * 必填
     * 微信退款单号
     * - 字段 refund_id_$n	
     *
     * @var string(32)
     */
    public $refund_ids;
    
    /**
     * 退款渠道	
     * 可选
     *  - ORIGINAL—原路退款
     *  - BALANCE—退回到余额
     *  - OTHER_BALANCE—原账户异常退到其他余额账户
     *  - OTHER_BANKCARD—原银行卡异常退到其他银行卡
     *  - 字段 refund_channel_$n	
     * @var string(16)
     */
    public $refund_channels;

    /**
     * 申请退款金额 如（100）
     * 必填
     * 退款总金额,单位为分,可以做部分退款
     *  - 字段 refund_fee_$n	
     *
     * @var int
     */
    public $refund_fees;

    /**
     * 退款金额 如（100）
     * 可选
     * 去掉非充值代金券退款金额后的退款金额，退款金额=申请退款金额-非充值代金券退款金额，退款金额<=申请退款金额
     * - 字段 settlement_refund_fee_$n	
     *
     * @var int
     */
    public $settlement_refund_fees;
    
    /**
     * 货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     * 必填
     * @var string(16)
     */
    public $cash_fee_type;

    /**
     * 现金退款金额 如（100）
     * 可选
     * 现金退款金额，单位为分，只能为整数，详见支付金额
     *
     * @var int
     */
    public $cash_refund_fee;

    /**
     * 代金券类型 如（CASH）
     * 可选
     * 退款代金券使用数量
     *  - CASH--充值代金券
     *  - NO_CASH---非充值代金券
     * 订单使用代金券时有返回（取值：CASH、NO_CASH）。$n为下标,从0开始编号，举例：coupon_type_0
     *
     * coupon_type_$n_$m	
     *
     * @var string(8)
     */
    public $coupon_types;
    
    /**
     * 退款代金券使用数量 如（1）
     * 可选
     * 退款代金券使用数量
     * coupon_refund_count_$n	
     *
     * @var int
     */
    public $coupon_refund_counts;

    /**
     * 退款代金券ID 如（10000）
     * 可选
     * 退款代金券ID, $n为下标，从0开始编号
     *
     * coupon_refund_id_$n_$m
     *
     * @var string(20)
     */
    public $coupon_refund_ids;
    
    /**
     * 单个代金券退款金额	如（100）
     * 单个退款代金券支付金额, $n为下标，$m为下标，从0开始编号
     * coupon_refund_fee_$n
     * coupon_refund_fee_$n_$m	
     * @var Int
     */
    public $coupon_refund_fees;
    
    /**
     * 退款状态	
     * - SUCCESS—退款成功
     * - REFUNDCLOSE—退款关闭。
     * - PROCESSING—退款处理中
     * - CHANGE—退款异常，退款到银行发现用户的卡作废或者冻结了，导致原路退款银行卡失败，可前往商户平台（pay.weixin.qq.com）-交易中心，手动处理此笔退款。$n为下标，从0开始编号。
     * 
     * refund_status_$n	
     * @var String(16)
     */
    public $refund_statuss;
    
    /**
     * 退款资金来源	
     * - REFUND_SOURCE_RECHARGE_FUNDS---可用余额退款/基本账户
     * - REFUND_SOURCE_UNSETTLED_FUNDS---未结算资金退款
     * - $n为下标，从0开始编号。
     * refund_account_$n
     * @var String(30)
     */
    public $refund_accounts;
    
    /**
     * 退款入账账户	
     * 取当前退款单的退款入账方
     * - 1）退回银行卡：{银行名称}{卡类型}{卡尾号}
     * - 2）退回支付用户零钱: 支付用户零钱
     * - 3）退还商户: 商户基本账户 商户结算银行账户
     * - 4）退回支付用户零钱通: 支付用户零钱通
     * refund_recv_accout_$n	
     * @var String(64)	
     */
    public $refund_recv_accouts;

    /**
     * 退款成功时间	
     * 退款成功时间，当退款状态为退款成功时有返回。$n为下标，从0开始编号。
     * refund_success_time_$n	
     * @var String(20)	
     */
    public $refund_success_times;
}
