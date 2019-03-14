<?php
namespace asbamboo\openpayWxpay\wxpayApi\requestParams\unit;

use asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParams;

/**
 * 统一下单 APP支付 请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月17日
 */
class AppByPayUnifiedorderParams extends RequestParams
{

    /**
     * 商品描述 如（腾讯充值中心-QQ会员充值）
     * 必须
     * 商品简单描述，该字段须严格按照规范传递，具体请见参数规定
     *
     * @var string(128)
     */
     public $body;

     /**
      * 商品详情
      * 可选
      * 单品优惠字段(暂未上线)
      *
      * @var string(8192)
      */
     public $detail;

     /**
      * 附加数据 如（深圳分店）
      * 可选
      * 附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
      *
      * @var string(127)
      */
     public $attach;

     /**
      * 商户订单号 如（20150806125346）
      * 必须
      * 商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
      *
      * @var string(32)
      */
     public $out_trade_no;

     /**
      * 货币类型 如（CNY）
      * 可选
      * 符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
      *
      * @var string(16)
      */
     public $fee_type;

     /**
      * 订单总金额 如（888）
      * 必须
      * 单位为分，详见支付金额
      *
      * @var int
      */
     public $total_fee;

     /**
      * 终端IP 如（123.12.12.123）
      * 必须
      * 必须传正确的用户端IP,详见获取用户ip指引
      *
      * @var string(64)
      */
     public $spbill_create_ip;

     /**
      * 交易起始时间 如（20091225091010）
      * 可选
      * 订单生成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010。其他详见时间规则      *
      * @var string(14)
      */
     public $time_start;

     /**
      * 交易结束时间 如（20091227091010）
      * 可选
      * 订单失效时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。其他详见时间规则
      * 注意：最短失效时间间隔必须大于5分钟
      *
      * @var string(14)
      */
     public $time_expire;

     /**
      * 商品标记 如（WXG）
      * 可选
      * 商品标记，代金券或立减优惠功能的参数，说明详见代金券或立减优惠
      *
      * @var string(32)
      */
     public $goods_tag;

     /**
      * 通知地址 如（http://www.weixin.qq.com/wxpay/pay.php）
      * 必须
      * 接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
      *
      * @var string(256)
      */
     public $notify_url;

     /**
      * 交易类型 如（APP）
      * 必须
      *
      * @var string(16)
      */
     public $trade_type = 'APP';

     /**
      * 指定支付方式 如（no_credit）
      * 可选
      * no_credit--指定不能使用信用卡支付
      *
      * @var string(32)
      */
     public $limit_pay;

     /**
      * 开发票入口开放标识
      * 可选
      *  - Y，传入Y时，支付成功消息和支付详情页将出现开票入口。需要在微信支付商户平台或微信公众平台开通电子发票功能，传此字段才可生效
      *
      * @var string(8)
      */
     public $receipt;
}
