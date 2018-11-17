<?php
namespace asbamboo\openpayWxpay\wxpayApi\response;

/**
 * 统一下单 H5 响应结果
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月12日
 */
class H5ByPayUnifiedorderResponse extends ResponseAbstract
{
    /**
     * 必填
     * 交易类型
     * JSAPI 公众号支付 NATIVE 扫码支付 APP APP支付 说明详见参数规定
     *
     * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=4_2
     * @var string(16)
     */
    public $trade_type;

    /**
     * 必填
     * 预支付交易会话标识
     * 微信生成的预支付会话标识，用于后续接口调用中使用，该值有效期为2小时
     *
     * @var string(64)
     */
    public $prepay_id;

    /**
     * 必填
     * 支付跳转链接
     * trade_type为NATIVE时有返回，用于生成二维码，展示给用户进行扫码支付
     *
     * @var String(64)
     */
    public $mweb_url;
}
