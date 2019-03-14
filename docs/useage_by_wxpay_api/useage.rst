作为微信支付接口处理库使用
==================================
asbamboo/openpay-wxpay作为微信支付的接口处理库使用示例
-------------------------------------------------------------

::

    <?php 

        use asbamboo\openpayWxpay\wxpayApi\Client;

        ... 

        $wxpay_response    = Client::request('NativeByPayUnifiedorder', $request_data);

        if($wxpay_response->get('code') == NativeByPayUnifiedorderResponse::RETURN_CODE_SUCCESS && $wxpay_response->get('sub_code') == NativeByPayUnifiedorderResponse::RESULT_CODE_SUCCESS){

            // 请求成功。
            
        }
            
        ... 

如示例中所示 Client::request 接受两个参数:
-------------------------------------------

#. 第一个参数时接口的名称

    *asbamboo/openpay-wxpay中接口名称与微信接口对应关系*
    
    =============================== =============================================================
    接口名称                            微信中接口链接 
    =============================== =============================================================
    NativeByPayUnifiedorder          https://api.mch.weixin.qq.com/pay/unifiedorder （Native支付）
    H5ByPayUnifiedorder              https://api.mch.weixin.qq.com/pay/unifiedorder （H5支付）
    AppByPayUnifiedorder             https://api.mch.weixin.qq.com/pay/unifiedorder （APP支付）
    PayRefund                        https://api.mch.weixin.qq.com/secapi/pay/refund （申请退款）
    OrderQuery                       https://api.mch.weixin.qq.com/pay/orderquery （查询订单）
    CloseOrder                       https://api.mch.weixin.qq.com/pay/closeorder （关闭订单）
    =============================== =============================================================

#. 第二个参数为请求的参数，array 类型 key 为参数的名称，value为参数的值。各个接口对应的参数，请参考 https://pay.weixin.qq.com/wiki/doc/api/index.html

    


如示例所示 Client::request 方法有返回值 $wxpay_response:
-------------------------------------------------------------------------------

$wxpay_response 是 asbamboo\\openpayWxpay\\wxpayApi\\response\\ResponseInterface 实例。

Client::request 将微信的响应值转换为一个 asbamboo\\openpayWxpay\\wxpayApi\\response\\ResponseInterface 实例返回。在 wxpay-api/response目录下编写了各个接口的响应值转换类，响应值类名的规则时，请求接口名+后缀Response。如示例中的响应值转换类为 NativeByPayUnifiedorderResponse.

$wxpay_response 使用 get 方法获取各个响应值。如示例所示，使用 $wxpay_response->get('return_code') 判断接口响应的状态码。
