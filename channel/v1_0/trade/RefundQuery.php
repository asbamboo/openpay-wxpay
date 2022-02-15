<?php
namespace asbamboo\openpayWxpay\channel\v1_0\trade;

use asbamboo\openpayWxpay\Constant;
use asbamboo\openpay\channel\v1_0\trade\RefundQueryParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\RefundQueryParameter\Response;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayWxpay\Env;
use asbamboo\openpayWxpay\wxpayApi\Client;
use asbamboo\openpayWxpay\wxpayApi\response\PayRefundResponse;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\openpayWxpay\exception\ResponseFormatException;
use asbamboo\api\exception\ApiException;
use asbamboo\openpay\channel\v1_0\trade\RefundQueryInterface;
use asbamboo\openpayWxpay\channel\v1_0\traits\RefundStatusTrait;

/**
 * 申请退款
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class RefundQuery implements RefundQueryInterface
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
                'out_refund_no'     => $Request->getInRefundNo(),
            ];

            $wx_params          = json_decode((string) $Request->getThirdPart(), true);
            if(is_array($wx_params)){
                foreach($wx_params AS $wx_key => $wx_value){
                    $request_data[$wx_key] = $wx_value;
                }
            }
            
            $WxResponse                 = Client::request('RefundQuery', $request_data);
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
            $Response               = new Response();
            $refund_status          = current((array) $WxResponse->get('refund_statuss'));
            $refund_success_time    = current((array) $WxResponse->get('refund_success_times'));
            $Response->setInRefundNo($Request->getInRefundNo());
            $Response->setRefundStatus($this->convertRefundStatus($refund_status));
            if($refund_success_time){
                $Response->setRefundPayYmdhis($refund_success_time);
            }
            return $Response;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
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