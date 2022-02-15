<?php
namespace asbamboo\openpayWxpay\wxpayApi\request;

use asbamboo\openpayWxpay\wxpayApi\gateway\GatewayUriTrait;
use asbamboo\openpayWxpay\wxpayApi\request\tool\BodyTrait;
use asbamboo\openpayWxpay\wxpayApi\request\tool\CreateRequestTrait;
use asbamboo\http\UriInterface;
use asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParamsInterface;
use asbamboo\openpayWxpay\wxpayApi\requestParams\unit\RefundQueryParams;

/**
 * 申请退款
 *
 * @see https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=9_4&index=4
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class RefundQuery implements RequestInterface
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
        $path   = rtrim($Uri->getPath(), '/') . '/pay/refundquery';
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
        $this->RequestParams  = new RefundQueryParams();
        $this->RequestParams->mappingData($assign_data);
        return $this;
    }
}
