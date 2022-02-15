<?php 
namespace asbamboo\openpayWxpay\channel\v1_0\traits;

use asbamboo\openpay\Constant AS OpenpayConstant;

/**
 * 
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年9月4日
 */
trait RefundStatusTrait
{
    /**
     * 转换交易状态
     *
     * @param string $alipay_trade_status
     */
    public function convertRefundStatus(string $refund_status)
    {
        if($refund_status == 'SUCCESS'){
            return OpenpayConstant::TRADE_REFUND_STATUS_SUCCESS;
        }
        return OpenpayConstant::TRADE_REFUND_STATUS_FAILED;
    }
}
