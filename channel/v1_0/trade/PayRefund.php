<?php
namespace asbamboo\openpayWxpay\channel\v1_0\trade;

use asbamboo\openpay\channel\v1_0\trade\RefundInterface;
use asbamboo\openpayWxpay\Constant;
use asbamboo\openpay\channel\v1_0\trade\RefundParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\RefundParameter\Response;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayWxpay\Env;
use asbamboo\openpayWxpay\wxpayApi\Client;
use asbamboo\openpayWxpay\wxpayApi\response\PayRefundResponse;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\openpayWxpay\exception\ResponseFormatException;
use asbamboo\api\exception\ApiException;
use asbamboo\http\ServerRequestInterface;
use asbamboo\openpay\channel\v1_0\trade\refundParameter\NotifyResult;
use asbamboo\openpayWxpay\channel\v1_0\traits\RefundStatusTrait;

/**
 * 申请退款
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class PayRefund implements RefundInterface
{
    use RefundStatusTrait;
    
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\RefundInterface::execute()
     */
    public function execute(Request $Request) : Response
    {
        try{
            $request_data           = [
                'appid'             => (string) EnvHelper::get(Env::WXPAY_APP_ID),
                'mch_id'            => (string) EnvHelper::get(Env::WXPAY_MCH_ID),
                'out_trade_no'      => $Request->getInTradeNo(),
                'total_fee'         => $Request->getTradePayFee(),
                'out_refund_no'     => $Request->getInRefundNo(),
                'refund_fee'        => $Request->getRefundFee(),
                'notify_url'        => $Request->getNotifyUrl(),
            ];
            $wx_params          = json_decode((string) $Request->getThirdPart(), true);
            if(is_array($wx_params)){
                foreach($wx_params AS $wx_key => $wx_value){
                    $request_data[$wx_key] = $wx_value;
                }
            }
            
            Client::$is_send_ssl_key    = true;
            $WxResponse                 = Client::request('PayRefund', $request_data);
            if(     $WxResponse->get('return_code') != PayRefundResponse::RETURN_CODE_SUCCESS
                ||  $WxResponse->get('result_code') != PayRefundResponse::RESULT_CODE_SUCCESS
            ){
                $Exception                          = new Api3NotSuccessResponseException('微信返回的响应值表示这次业务没有处理成功。');
                $ApiResponseParams                  = new ApiResponseParams();
                $ApiResponseParams->return_code     = $WxResponse->get('return_code');
                $ApiResponseParams->return_msg      = $WxResponse->get('return_msg');
                $ApiResponseParams->result_code     = $WxResponse->get('result_code');
                $ApiResponseParams->err_code        = $WxResponse->get('err_code');
                $ApiResponseParams->err_code_des    = $WxResponse->get('err_code_des');
                $Exception->setApiResponseParams($ApiResponseParams);
                throw $Exception;
            }
            $Response           = new Response();
            $Response->setInRefundNo($Request->getInRefundNo());
            $Response->setIsSuccess(true);
            $Response->setRefundFee($WxResponse->get('refund_fee'));
            return $Response;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\RefundInterface::notify()
     */
    public function notify(ServerRequestInterface $Request) : NotifyResult
    {
        $xml            = $Request->getBody()->getContents();
        
        libxml_disable_entity_loader(true);
        $decoded_xml    = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        
        if(empty($decoded_xml['req_info'])){
            throw new Api3NotSuccessResponseException(sprintf('微信返回的响应结果异常[%s]', $xml));
        }
        
        $req_info_xml           = openssl_decrypt(base64_decode($decoded_xml['req_info']), 'aes-256-ecb', md5(EnvHelper::get(Env::WXPAY_SIGN_KEY)), OPENSSL_RAW_DATA);

        $decoded_req_info_xml   = json_decode(json_encode(simplexml_load_string($req_info_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        $NotifyResult       = new NotifyResult();
        $NotifyResult->setInRefundNo($decoded_req_info_xml['out_refund_no']);
        if($decoded_req_info_xml['success_time']){    
            $NotifyResult->setRefundPayYmdhis($decoded_req_info_xml['success_time']);
        }
        $NotifyResult->setRefundStatus($this->convertRefundStatus($decoded_req_info_xml['refund_status']));
        $NotifyResult->setResponseSuccess("<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>");
        $NotifyResult->setResponseFailed("<xml><return_code><![CDATA[FAILED]]></return_code><return_msg><![CDATA[ERROR]]></return_msg></xml>");
        $NotifyResult->setThirdPart($xml);
        
        return $NotifyResult;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::supports()
     */
    public function supports() : array
    {
        return [
            Constant::CHANNEL_WXPAY_ONECD   => Constant::CHANNEL_WXPAY_ONECD_LABEL,
            Constant::CHANNEL_WXPAY_H5      => Constant::CHANNEL_WXPAY_H5_LABEL,
            Constant::CHANNEL_WXPAY_QRCD    => Constant::CHANNEL_WXPAY_QRCD_LABEL,
        ];
    }
}