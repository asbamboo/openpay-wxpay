<?php
namespace asbamboo\openpayWxpay\wxpayApi;

use asbamboo\openpayWxpay\wxpayApi\response\ResponseInterface;

/**
 * 微信支付请求接口
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月22日
 */
interface ClientInterface
{
    /**
     * 发起一个接口请求
     *
     * @param string $api_name api请求构件名称 如 ScanQRCodeByPayUnifiedorder
     * @param array $assign_data api请求构件指派的数据集
     * @return ResponseInterface 响应结果
     */
    public function request(string $api_name, array $assign_data = []) : ResponseInterface;
}
