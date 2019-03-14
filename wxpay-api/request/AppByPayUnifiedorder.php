<?php
namespace asbamboo\openpayWxpay\wxpayApi\request;

use asbamboo\openpayWxpay\wxpayApi\gateway\GatewayUriTrait;
use asbamboo\http\UriInterface;
use asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParamsInterface;
use asbamboo\openpayWxpay\wxpayApi\request\tool\BodyTrait;
use asbamboo\openpayWxpay\wxpayApi\request\tool\CreateRequestTrait;
use asbamboo\openpayWxpay\wxpayApi\requestParams\unit\AppByPayUnifiedorderParams;

/**
 * 微信App支付 统一下单接口
 *
 * https://api.mch.weixin.qq.com/pay/unifiedorder
 *
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_1
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月12日
 */
class AppByPayUnifiedorder implements RequestInterface
{
    use GatewayUriTrait;
    use BodyTrait;
    use CreateRequestTrait;

    /**
     *
     * @var RequestParamsInterface
     */
    private $RequestParams;

    /**
     * 返回接口请求uri
     *
     * @return UriInterface
     */
    public function uri() : UriInterface
    {
        $Uri    = $this->getGateway();
        $path   = rtrim($Uri->getPath(), '/') . '/pay/unifiedorder';
        $Uri    = $Uri->withPath($path);
        return $Uri;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayWxpay\wxpayApi\request\RequestInterface::assignData()
     */
    public function assignData(array $assign_data) : RequestInterface
    {
        $this->RequestParams  = new AppByPayUnifiedorderParams();
        $this->RequestParams->mappingData($assign_data);
        return $this;
    }
}