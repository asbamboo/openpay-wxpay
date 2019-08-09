<?php
namespace asbamboo\openpayWxpay\wxpayApi\requestParams\unit;

use asbamboo\openpayWxpay\wxpayApi\sign\SignTrait;
use asbamboo\openpayWxpay\wxpayApi\sign\SignType;

/**
 * 统一下单 JSAPI 请求参数
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月17日
 */
class SandBoxSignParams
{
    use SignTrait;
    
    /**
     *  微信支付分配的微信商户号
     * @var string(32)
     */
    public $mch_id;
    
    /**
     * 随机字符串，不长于32位
     * @var string(32)
     */
    public $nonce_str;
    
    /**
     *  签名值
     *  
     * @var string(32)
     */
    public $sign;
    
    /**
     * 
     */
    public function __construct()
    {
        $this->nonce_str    = md5(uniqid());
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayWxpay\wxpayApi\requestParams\RequestParamsInterface::mappingData()
     */
    public function mappingData(array $assign_data) : void
    {
        foreach($assign_data AS $key => $value){
            if(property_exists($this, $key)){
                $this->{$key}   = $value;
            }
        }
        
        $this->sign = $this->makeSign(get_object_vars($this), SignType::MD5);
    }
}
