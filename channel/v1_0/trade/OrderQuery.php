<?php
namespace asbamboo\openpayWxpay\channel\v1_0\trade;

use asbamboo\openpay\channel\v1_0\trade\QueryInterface;
use asbamboo\openpay\channel\v1_0\trade\queryParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\queryParameter\Response;
use asbamboo\openpay\Constant AS OpenpayConstant;
use asbamboo\openpayWxpay\Constant;
use asbamboo\openpayWxpay\exception\ResponseFormatException;
use asbamboo\api\exception\ApiException;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayWxpay\Env;
use asbamboo\openpayWxpay\wxpayApi\Client;
use asbamboo\openpayWxpay\wxpayApi\response\OrderQueryResponse;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\api\apiStore\ApiResponseParams;

/**
 * 订单查询
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月19日
 */
class OrderQuery implements QueryInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\QueryInterface::execute()
     */
    public function execute(Request $Request) : Response
    {
        try{
            $request_data           = [
                'appid'             => (string) EnvHelper::get(Env::WXPAY_APP_ID),
                'mch_id'            => (string) EnvHelper::get(Env::WXPAY_MCH_ID),
                'out_trade_no'      => $Request->getInTradeNo(),
            ];

            $WxResponse                             = Client::request('H5ByPayUnifiedorder', $request_data);
            if(     $WxResponse->get('return_code') != OrderQueryResponse::RETURN_CODE_SUCCESS
                ||  $WxResponse->get('result_code') != OrderQueryResponse::RESULT_CODE_SUCCESS
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
            $Response->setInTradeNo($WxResponse->get('out_trade_no'));
            $Response->setThirdTradeNo($WxResponse->get('transaction_id'));
            $Response->setTradeStatus($this->convertTradeStatus($WxResponse->get('trade_state')));

            return $Response;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 转换交易状态
     *
     * @param string $alipay_trade_status
     */
    private function convertTradeState(string $trade_state)
    {
        return [
            'SUCCESS'       => OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYOK, //（支付成功）
            'REFUND'        => OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYOK, //（转入退款）
            'NOTPAY'        => OpenpayConstant::TRADE_PAY_TRADE_STATUS_NOPAY, //（未支付）
            'CLOSED'        => OpenpayConstant::TRADE_PAY_TRADE_STATUS_CANCEL, //（已关闭）
            'REVOKED'       => OpenpayConstant::TRADE_PAY_TRADE_STATUS_CANCEL, //（已撤销（刷卡支付））
            'USERPAYING'    => OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYING, //（用户支付中）
            'PAYERROR'      => OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYFAILED, //（支付失败(其他原因，如银行返回失败)）
        ][$trade_state];
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::supports()
     */
    public function supports() : array
    {
        return [
            Constant::CHANNEL_WXPAY_H5     => Constant::CHANNEL_WXPAY_H5_LABEL,
            Constant::CHANNEL_WXPAY_QRCD   => Constant::CHANNEL_WXPAY_QRCD_LABEL,
        ];
    }
}