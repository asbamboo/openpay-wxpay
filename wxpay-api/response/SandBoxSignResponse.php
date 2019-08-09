<?php
namespace asbamboo\openpayWxpay\wxpayApi\response;

use asbamboo\http\ResponseInterface AS HttpResponseInterface;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;

/**
 * 获取沙箱签名 接口响应值
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月20日
 */
class SandBoxSignResponse implements ResponseInterface
{
    /**
     * SUCCESS/FAIL 此字段是通信标识，非交易标识
     * 
     * @var String(16)
     */
    private $return_code;

    /**
     * 返回信息，如非空，为错误原因 ，签名失败 ，参数格式校验错误
     * 
     * @var String(16)
     */
    private $return_msg;
    
    /**
     * 微信支付分配的微信商户号
     * 
     * @var String(32)	
     */
    private $mch_id;
    
    /**
     * 返回的沙箱密钥
     * 
     * @var String(32)
     */
    private $sandbox_signkey;
    
    /**
     *
     * {@inheritDoc}
     * @see ResponseInterface::__construct()
     */
    public function __construct(HttpResponseInterface $Response)
    {
        $this->parseResposne($Response);
    }
    
    /**
     *
     * {@inheritDoc}
     * @see ResponseInterface::get()
     */
    public function get(string $key)
    {
        return $this->{$key};
    }
    
    /**
     * 解析响应结果生成实体类属性列表
     *
     * @param HttpResponseInterface $Response
     */
    private function parseResposne(HttpResponseInterface $Response)
    {
        /**
         * 将XML转为array 禁止引用外部xml实体
         */
        libxml_disable_entity_loader(true);
        $xml            = $Response->getBody()->getContents();
        
        $decoded_xml    = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        $this->checkResponse($xml, $decoded_xml);
        
        $setting_json_propertys  = [];
        foreach($decoded_xml AS $key => $value){
            if(preg_match('#([a-zA-Z_])+(_)(\$\d+)#', $key, $matches)){
                $property   = $matches[1] . 's';
                if(property_exists($this, $property)){
                    $setting_json_propertys[$property][]    = $value;
                }
            }elseif(property_exists($this, $key)){
                $this->{$key}   = $value;
            }
        }
        foreach($setting_json_propertys AS $property => $value){
            $this->{$property}  = $value;
        }
    }
    
    /**
     * 检查响应结果是否有效
     * 
     * @param string $xml
     * @param array $decoded_xml
     * @throws Api3NotSuccessResponseException
     */
    private function checkResponse(string $xml, $decoded_xml)
    {
        if(!isset( $decoded_xml['return_code'] ) || $decoded_xml['return_code'] != 'SUCCESS'){
            throw new Api3NotSuccessResponseException(sprintf('获取微信沙箱测试key失败:%s', $xml));
        }
    }
}
