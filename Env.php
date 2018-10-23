<?php
namespace asbamboo\openpayWxpay;

/**
 * 常量配置
 * 环境变量的key
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月10日
 */
final class Env
{
    /*********************************************************************************************
     * 微信环境变量
     *********************************************************************************************/
    // 微信支付接口网关uri
    const WXPAY_GATEWAY_URI         = 'OPENPAY_WXPAY_GATEWAY_URI';
    // 生成微信签名的key
    const WXPAY_SIGN_KEY            = 'OPENPAY_WXPAY_SIGN_KEY';
    // 微信 appid
    const WXPAY_APP_ID              = 'OPENPAY_WXPAY_APP_ID';
    // 微信商户号
    const WXPAY_MCH_ID              = 'OPENPAY_WXPAY_MCH_ID';
    // 微信扫码支付的消息推送 notify url
    const WXPAY_QRCD_NOTIFY_URL     = "OPENPAY_WXPAY_QRCD_NOTIFY_URL";
    /*********************************************************************************************/
}