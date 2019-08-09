<?php
namespace asbamboo\openpayWxpay\channel\v1_0\trade;

use asbamboo\http\ServerRequestInterface;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\api\exception\ApiException;
use asbamboo\openpayWxpay\wxpayApi\Client;
use asbamboo\openpayWxpay\Env;
use asbamboo\openpayWxpay\exception\ResponseFormatException;
use asbamboo\openpayWxpay\Constant;
use asbamboo\openpay\channel\v1_0\trade\payParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\payParameter\Response;
use asbamboo\openpay\channel\v1_0\trade\payParameter\NotifyResult;
use asbamboo\openpay\channel\v1_0\trade\PayInterface;
use asbamboo\openpayWxpay\wxpayApi\response\NativeByPayUnifiedorderResponse;
use asbamboo\openpayWxpay\wxpayApi\sign\SignType;
use asbamboo\openpayWxpay\wxpayApi\sign\SignTrait;

/**
 * openpay[trade.pay] 渠道:微信扫码支付
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月22日
 */
class PayWxpayOnecd implements PayInterface
{
    use SignTrait;
    
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::execute()
     */
    public function execute(Request $Request) : Response
    {
        try{
            $request_data           = [
                'appid'             => (string) EnvHelper::get(Env::WXPAY_APP_ID),
                'mch_id'            => (string) EnvHelper::get(Env::WXPAY_MCH_ID),
                'body'              => $Request->getTitle(),
                'out_trade_no'      => $Request->getInTradeNo(),
                'total_fee'         => $Request->getTotalFee(),
                'spbill_create_ip'  => $Request->getClientIp(),
                'notify_url'        => $Request->getNotifyUrl(),
            ];
            $wx_params              = json_decode((string) $Request->getThirdPart(), true);
            if(is_array($wx_params)){
                foreach($wx_params AS $wx_key => $wx_value){
                    $request_data[$wx_key] = $wx_value;
                }
            }

            $WxResponse                             = Client::request('JSAPIByPayUnifiedorder', $request_data);
            if(     $WxResponse->get('return_code') != NativeByPayUnifiedorderResponse::RETURN_CODE_SUCCESS
                ||  $WxResponse->get('result_code') != NativeByPayUnifiedorderResponse::RESULT_CODE_SUCCESS
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
            $onecd_pay_data                 = [];
            $onecd_pay_data['appId']        = $WxResponse->get('appid');
            $onecd_pay_data['timeStamp']    = time();
            $onecd_pay_data['nonceStr']     = $WxResponse->get('nonce_str');
            $onecd_pay_data['package']      = 'prepay_id=' . $WxResponse->get('prepay_id');
            $onecd_pay_data['signType']     = SignType::MD5;
            $onecd_pay_data['paySign']      = $this->makeSign($onecd_pay_data, SignType::MD5);
            
            $Response               = new Response();
            $Response->setType(Response::TYPE_ONECD);
            $Response->setOnecdPayJson(json_encode($onecd_pay_data));
            
            return $Response;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::notify()
     */
    public function notify(ServerRequestInterface $Request): NotifyResult
    {

    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::notify()
     */
    public function return(ServerRequestInterface $Request): NotifyResult
    {

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
        ];
    }
}