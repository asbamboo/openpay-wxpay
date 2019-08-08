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

/**
 * 申请退款
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class PayRefund implements RefundInterface
{
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
                'out_refund_no'     => $Request->getInRefundNo(),
                'refund_fee'        => $Request->getRefundFee(),
            ];

            $WxResponse = Client::request('PayRefund', $request_data);
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