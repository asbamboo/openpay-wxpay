<?php 
namespace asbamboo\openpayWxpay\channel\v1_0\traits;

use asbamboo\openpay\Constant AS OpenpayConstant;

trait TradeStateTrait
{
    /**
     * 转换交易状态
     *
     * @param string $alipay_trade_status
     */
    public function convertTradeState(string $trade_state)
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
}
