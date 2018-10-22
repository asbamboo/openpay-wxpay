<?php
namespace asbamboo\openpayWxpay\channel\v1_0\trade;

use asbamboo\openpay\channel\v1_0\trade\PayInterface;
use asbamboo\openpay\apiStore\parameter\v1_0\trade\PayRequest;
use asbamboo\openpay\apiStore\parameter\v1_0\trade\PayResponse;
use asbamboo\openpayWxpay\Env;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\api\exception\ApiException;
use asbamboo\openpayWxpay\wxpayApi\response\ScanQRCodeByPayUnifiedorderResponse;
use asbamboo\openpayWxpay\wxpayApi\Client;

/**
 * openpay[trade.pay] 渠道:微信扫码支付
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月22日
 */
class PayWxpayQrcd implements PayInterface
{
    /**
     * 微信扫码支付
     *
     * @var string
     */
    const NAME  = 'WXPAY_QRCD'; // 微信扫码支付

    /**
     *
     * @param PayRequest $PayRequest
     * @return PayResponse
     */
    public function execute(PayRequest $PayRequest) : PayResponse
    {
        try{
            $request_data           = [
                'appid'             => (string) EnvHelper::get(Env::WXPAY_APP_ID),
                'mch_id'            => (string) EnvHelper::get(Env::WXPAY_MCH_ID),
                'body'              => $Params->getTitle(),
                'out_trade_no'      => $Params->getOutTradeNo(),
                'total_fee'         => $Params->getTotalFee(),
                'spbill_create_ip'  => $Params->getClientIp(),
                'notify_url'        => EnvHelper::get(Env::WXPAY_QRCD_NOTIFY_URL),
            ];
            $wx_params              = json_decode((string) $Params->getThirdPart(), true);
            if(is_array($wx_params)){
                foreach($wx_params AS $wx_key => $wx_value){
                    $request_data[$wx_key] = $wx_value;
                }
            }

            $WxResponse                             = Client::request('ScanQRCodeByPayUnifiedorder', $request_data);
            if(     $WxResponse->get('return_code') != ScanQRCodeByPayUnifiedorderResponse::RETURN_CODE_SUCCESS
                ||  $WxResponse->get('result_code') != ScanQRCodeByPayUnifiedorderResponse::RESULT_CODE_SUCCESS
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
            $PayResponse                            = new PayResponse();
            $PayResponse->_redirect_data['qr_code'] = $WxResponse->get('code_url');
            return $PayResponse;
        }catch(\asbamboo\openpay\exception\ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::getName()
     */
    public function getName()
    {
        return self::getName();
    }
}