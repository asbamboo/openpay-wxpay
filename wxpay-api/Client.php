<?php
namespace asbamboo\openpayWxpay\wxpayApi;

use asbamboo\openpayWxpay\wxpayApi\response\ResponseInterface;
use asbamboo\openpayWxpay\wxpayApi\request\RequestInterface;
use asbamboo\openpayWxpay\exception\NotFindApiRequestException;
use asbamboo\http\RequestInterface AS HttpRequestInterface;
use asbamboo\http\ResponseInterface AS HttpResponseInterface;
use asbamboo\openpayWxpay\exception\NotFindApiResponseException;
use asbamboo\http\Client AS HttpClient;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayWxpay\Env;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月22日
 */
class Client implements ClientInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayWxpay\wxpayApi\ClientInterface::request()
     */
    public static function request(string $api_name, array $assign_data = []) : ResponseInterface
    {
        if(strpos(EnvHelper::get(Env::WXPAY_GATEWAY_URI), 'sandboxnew')){
            // 如果是沙箱环境，需要获取沙箱环境的秘钥 
            $Request        = static::createRequest('SandBoxSign');
            $Request        = $Request->assignData([
                'mch_id'    => EnvHelper::get(Env::WXPAY_MCH_ID),
            ]);
            $HttpRequest    = $Request->create();
            $HttpResponse   = static::sendRequest($HttpRequest);
            $Response       = static::transformResponse('SandBoxSign', $HttpResponse);
                        
            EnvHelper::set(Env::WXPAY_SIGN_KEY, $Response->get('sandbox_signkey'));
        }
        
        $Request        = static::createRequest($api_name);
        $Request        = $Request->assignData($assign_data);
        $HttpRequest    = $Request->create();
        $HttpResponse   = static::sendRequest($HttpRequest);
        $Response       = static::transformResponse($api_name, $HttpResponse);

        return $Response;
    }

    /**
     * 返回一个Http Request实例
     *
     * @param string $api_name
     * @throws NotFindApiRequestException
     * @return RequestInterface
     */
    private static function createRequest(string $api_name) : RequestInterface
    {
        $class_name         = __NAMESPACE__ . "\\request\\{$api_name}";
        if(!class_exists($class_name)){
            throw new NotFindApiRequestException(sprintf('找不到请求微信接口相关的类：%s', $api_name));
        }
        return new $class_name;
    }

    /**
     * 发送请求并且返回得到的响应值
     *
     * @param HttpRequestInterface $HttpRequest
     * @return HttpResponseInterface
     */
    private static function sendRequest(HttpRequestInterface $HttpRequest) : HttpResponseInterface
    {
        static $Client  = null;
        if(is_null($Client)){
            $Client = new HttpClient();
        }
        return $Client->send($HttpRequest);
    }

    /**
     *
     * @param string $api_name
     * @param HttpResponseInterface $HttpResponse
     * @return ResponseInterface
     */
    private static function transformResponse(string $api_name, HttpResponseInterface $HttpResponse) : ResponseInterface
    {
        $response_class     = __NAMESPACE__ . "\\response\\{$api_name}Response";
        if(!class_exists($response_class)){
            throw new NotFindApiResponseException(sprintf('%s接口:找不到转换响应值的类。', $api_name));
        }
        return new $response_class($HttpResponse);
    }
}
