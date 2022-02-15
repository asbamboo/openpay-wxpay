<?php
namespace asbamboo\openpayWxpay\_test\channel\v1_0\trade;

use PHPUnit\Framework\TestCase;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年1月13日
 */
class PayWxpayAppTest extends TestCase
{
    public $server;
    public $request;

    public function setUp()
    {
        $this->server   = $_SERVER;
        $this->request  = $_REQUEST;
    }

    public function tearDown()
    {
        $_SERVER        = $this->server;
        $_REQUEST       = $this->request;

    }

    public function testExecute()
    {
        $_SERVER['REQUEST_URI']     = '/api';
        $_REQUEST['api_name']       = 'trade.pay';
        $_REQUEST['version']        = 'v1.0';
        $_REQUEST['format']         = 'json';
        $_REQUEST['channel']        = 'WXPAY_APP';
        $_REQUEST['title']          = 'test WXPAY_APP';
        $_REQUEST['out_trade_no']   = strtotime('YmdHis') . rand(0, 9999);
        $_REQUEST['total_fee']      = rand(0, 9999);
        $_REQUEST['client_ip']      = '123.123.123.123';
        ob_start();
        include dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . 'web-demo' . DIRECTORY_SEPARATOR . 'index.php';
        $data       = ob_get_contents();
        $headers    = ob_list_handlers();
        ob_end_clean();
        $decode_data    = json_decode($data, true);
        $this->assertEquals('0', $decode_data['code'], $data);
        $this->assertEquals('success', $decode_data['message']);
        $this->assertEquals($_REQUEST['channel'], $decode_data['data']['channel']);
        $this->assertEquals($_REQUEST['out_trade_no'], $decode_data['data']['out_trade_no']);
        $this->assertEquals($_REQUEST['title'], $decode_data['data']['title']);
        $this->assertEquals($_REQUEST['total_fee'], $decode_data['data']['total_fee']);
        $this->assertEquals($_REQUEST['client_ip'], $decode_data['data']['client_ip']);
        $this->assertContains('app_pay_json', $data);
    }
}
