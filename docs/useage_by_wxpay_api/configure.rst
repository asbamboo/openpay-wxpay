作为微信支付接口处理库使用(配置)
==========================================================

asbamboo/openpay-wxpay作为微信支付的接口处理库使用时，需要使用asbamboo\\helper\\env\\Env::set("变量名", "变量值") 方法设置必要的环境变量。

应该设置的环境变量名被声明在asbamboo\\openpayWxpay\\Env 类中。

:OPENPAY_WXPAY_GATEWAY_URI: 请求微信接口的网关url，（各个接口公共的那部分url）。
:OPENPAY_WXPAY_SIGN_KEY: 生成微信请求参数sign，使用的key（https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=4_3）。
:OPENPAY_WXPAY_APP_ID: 微信分配的公众账号ID（接口中的appid参数）。
:OPENPAY_WXPAY_MCH_ID: 微信支付分配的商户号（接口中的mch_id参数）。

环境变量设置示例：

::

    <?php
    use asbamboo\helper\env\Env AS EnvHelper;
    use asbamboo\openpayWxpay\Env AS WxpayEnv;

    ...
    
    // 微信网关
    EnvHelper::set(WxpayEnv::WXPAY_GATEWAY_URI, 'https://api.mch.weixin.qq.com/');
    // 微信加密使用的key值
    EnvHelper::set(WxpayEnv::WXPAY_SIGN_KEY, 'xxxxxxxxxxxxxxxxxxxxxxxx');
    // 微信 appid
    EnvHelper::set(WxpayEnv::WXPAY_APP_ID, 'wxxxxxxxxx');
    // 微信商户号
    EnvHelper::set(WxpayEnv::WXPAY_MCH_ID, '0000000000');

    ...    