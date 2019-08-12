<?php
namespace asbamboo\openpayWxpay\channel\v1_0\traits;

use asbamboo\http\ServerRequestInterface;
use asbamboo\openpay\channel\v1_0\trade\payParameter\NotifyResult;
use asbamboo\openpayWxpay\wxpayApi\sign\SignTrait;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\openpayWxpay\wxpayApi\sign\SignType;
use asbamboo\openpayWxpay\wxpayApi\Client;
use asbamboo\openpayWxpay\wxpayApi\response\OrderQueryResponse;
use asbamboo\api\exception\ApiException;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月3日
 */
trait NotifyTrait
{
    use SignTrait;
    use TradeStateTrait;
    
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::notify()
     */
    public function notify(ServerRequestInterface $Request) : NotifyResult
    {
        $xml            = $Request->getBody()->getContents();
        
        libxml_disable_entity_loader(true);
        $decoded_xml    = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        
        if(empty($decoded_xml['transaction_id'])){
            throw new Api3NotSuccessResponseException(sprintf('微信返回的响应结果异常,缺少订单号[%s]', $xml));
        }
        
        $sign_type  = isset( $decoded_xml['sign_type'] ) ? $decoded_xml['sign_type'] : null;
        if(is_null($sign_type)){
            $sign_type  = strlen( $decoded_xml['sign'] ) > 32 ? SignType::HMAC_SHA256 : SignType::MD5;
        }            
        if($decoded_xml['sign'] != $this->makeSign($decoded_xml, $sign_type)){
            throw new Api3NotSuccessResponseException(sprintf('微信返回的响应结果异常,sign错误[%s]', $xml));
        }

        /**
         * 
         * @var array $query_data
         * @var OrderQueryResponse $OrderQueryResponse
         */
        $query_data                     = [];
        $query_data['appid']            = $decoded_xml['appid'];
        $query_data['mch_id']           = $decoded_xml['mch_id'];
        $query_data['transaction_id']   = $decoded_xml['transaction_id'];
        if(!empty($decoded_xml['sub_mch_id'])){
            $query_data['sub_mch_id']   = $decoded_xml['sub_mch_id'];   
        }
        if(!empty($decoded_xml['sub_appid'])){
            $query_data['sub_appid']   = $decoded_xml['sub_appid'];
        }
        $OrderQueryResponse = Client::request("OrderQuery", $query_data);

        $NotifyResult   = new NotifyResult();
        $NotifyResult->setResponseSuccess("<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>");
        $NotifyResult->setResponseFailed("<xml><return_code><![CDATA[FAILED]]></return_code><return_msg><![CDATA[ERROR]]></return_msg></xml>");
        $NotifyResult->setInTradeNo($OrderQueryResponse->get('out_trade_no'));
        $NotifyResult->setThirdTradeNo($OrderQueryResponse->get('transaction_id'));
        $NotifyResult->setThirdPart($xml);
        $NotifyResult->setTradeStatus($this->convertTradeState($OrderQueryResponse->get('trade_state')));

        return  $NotifyResult;        
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::return()
     */
    public function return(ServerRequestInterface $Request) : NotifyResult
    {
        return $this->notify($Request);
    }
}