<?php
namespace asbamboo\openpayWxpay;

use Composer\Script\Event;

class Script
{
    public function test(Event $Event)
    {
        $Composer   = $Event->getComposer();
        var_dump("\n============================================\n");
        var_dump($_SERVER);
        var_dump($_SERVER['pwd']); // 执行composer的目录
        var_dump($Composer->getConfig()->get('vendor-dir'));
        var_dump(__DIR__);exit;
//         var_dump($Composer->getConfig()->get('base_dir'));
//         var_dump($Composer->getConfig()->get('home'));
        var_dump("\n============================================\n");
        exit;

    }
}