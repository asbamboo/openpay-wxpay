作为支付渠道扩展使用的使用说明
===================================

根据 `asbamboo/openpay`_ 的文档说明，使用 asbamboo/openpay-wxpay 模块。

你可以按照 `asbamboo/openpay-example`_ 的安装与配置方法，运行web服务。web服务demo：http://demo.asbamboo.com/openpay-example/public

安装了asbamboo/openpay-wxpay 模块以后，交易支付（trade.pay）接口，将支持如下支付渠道（channel字段）：

:WXPAY_APP: 微信APP支付(手机app支付的服务端参数生成接口)
:WXPAY_H5: 微信H5支付
:WXPAY_QRCD: 微信扫码支付（买家手机扫商户）

.. _asbamboo/openpay: http://www.github.com/asbamboo/openpay
.. _asbamboo/openpay-example: http://www.github.com/asbamboo/openpay-example