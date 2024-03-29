<?php
use asbamboo\database\Factory;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayWxpay\Env AS WxpayEnv;

/***************************************************************************************************
 * 环境参数配置
 ***************************************************************************************************/
// 微信网关
EnvHelper::set(WxpayEnv::WXPAY_GATEWAY_URI, 'https://api.mch.weixin.qq.com/');
// EnvHelper::set(WxpayEnv::WXPAY_GATEWAY_URI, 'https://api.mch.weixin.qq.com/sandboxnew/');

// 微信加密使用的key值
EnvHelper::set(WxpayEnv::WXPAY_SIGN_KEY, '8934e7d15453e97507ef794cf7b0519d');

// 微信 appid
EnvHelper::set(WxpayEnv::WXPAY_APP_ID, 'wx426b3015555a46be');

// 微信商户号
EnvHelper::set(WxpayEnv::WXPAY_MCH_ID, '1900009851');

// 微信证书apiclient_cert.pem
EnvHelper::set(WxpayEnv::WXPAY_API_SSL_CERT, dirname(__DIR__) . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'apiclient_cert.pem');
// 微信证书apiclient_key.pem
EnvHelper::set(WxpayEnv::WXPAY_API_SSL_KEY, dirname(__DIR__) . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'apiclient_key.pem');
// /***************************************************************************************************/
// require dirname(__DIR__) . '/var/openpay-config.php';

/***************************************************************************************************
 * 数据库配置
 ***************************************************************************************************/
if(!$Container->has('db')){
    $DbFactory          = new Factory();
    $Connection         = require __DIR__ . DIRECTORY_SEPARATOR . 'db-connection.php';
    $DbFactory->addConnection($Connection);
    $Container->set('db', $DbFactory);
}
/***************************************************************************************************/
 