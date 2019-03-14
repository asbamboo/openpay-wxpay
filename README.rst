asbamboo/openpay-wxpay
===========================

asbamboo/openpay-wxpay 是 `asbamboo/openpay`_ 的一个支付渠道扩展模块。`查看文档`_

安装
---------------------

请根据 `asbamboo/openpay`_ 的说明: https://github.com/asbamboo/openpay/blob/master/docs/install.rst 将asbamboo/openpay-wxpay 应用到你的项目上。

参数配置
------------------------

asbamboo\\openpayWxpay\\Env 类中声明的几个常量，是使用 asbamboo//openpay-wxpay 必须配置的环境变量。通过asbamboo\\helper\\env\\Env::set("变量名", "变量值") 方法进行设置。

:OPENPAY_WXPAY_GATEWAY_URI: 请求微信接口的网关url，（各个接口公共的那部分url）。
:OPENPAY_WXPAY_SIGN_KEY: 生成微信请求参数sign，使用的key（https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=4_3）。
:OPENPAY_WXPAY_APP_ID: 微信分配的公众账号ID（接口中的appid参数）。
:OPENPAY_WXPAY_MCH_ID: 微信支付分配的商户号（接口中的mch_id参数）。


需要在 config/openpay-config.php 中配置环境变量：

::

    <?php
    use asbamboo\helper\env\Env AS EnvHelper;
    use asbamboo\openpayWxpay\Env AS WxpayEnv;
    /***************************************************************************************************
     * 环境参数配置
     ***************************************************************************************************/
    // 微信网关
    EnvHelper::set(WxpayEnv::WXPAY_GATEWAY_URI, 'https://api.mch.weixin.qq.com/');
    // 微信加密使用的key值
    EnvHelper::set(WxpayEnv::WXPAY_SIGN_KEY, 'xxxxxxxxxxxxxxxxxxxxxxxxxx');
    // 微信 appid
    EnvHelper::set(WxpayEnv::WXPAY_APP_ID, 'wxxxxxxxxxxxxxx');
    // 微信商户号
    EnvHelper::set(WxpayEnv::WXPAY_MCH_ID, '00000000000000');
        /***************************************************************************************************/

使用asbamboo/openpay-wxpay模块后，交易支付（trade.pay）接口将支持如下渠道（channel字段）
-------------------------------------------------------------------------------------------------------

:WXPAY_APP: 微信APP支付(手机app支付的服务端参数生成接口)
:WXPAY_H5: 微信H5支付
:WXPAY_QRCD: 微信扫码支付（买家手机扫商户）


.. _asbamboo/openpay: http://www.github.com/asbamboo/openpay
.. _查看文档: docs/index.rst