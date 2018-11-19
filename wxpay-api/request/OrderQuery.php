<?php
namespace asbamboo\openpayWxpay\wxpayApi\request;

use asbamboo\openpayWxpay\wxpayApi\gateway\GatewayUriTrait;
use asbamboo\openpayWxpay\wxpayApi\request\tool\BodyTrait;
use asbamboo\openpayWxpay\wxpayApi\request\tool\CreateRequestTrait;
use asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParamsInterface;
use asbamboo\http\UriInterface;
use asbamboo\openpayWxpay\wxpayApi\requestParams\unit\OrderQueryParams;

/**
 * 订单查询
 *
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_2&index=4
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月19日
 */
class OrderQuery implements RequestInterface
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
        $path   = rtrim($Uri->getPath(), '/') . '/pay/orderquery';
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
        $this->RequestParams  = new OrderQueryParams();
        $this->RequestParams->mappingData($assign_data);
        return $this;
    }
}