<?php
use asbamboo\database\Factory;

/**
 * 这个配置信息时为了执行命令行工具 ./vendor/bin/doctrine
 * 配置了数据库的基本信息
 *  - 通过 ./vendor/bin/doctrine orm:schema-tool:create 建立数据表
 */
$DbFactory          = new Factory();
$Connection         = require __DIR__ . DIRECTORY_SEPARATOR . 'db-connection.php';
$DbFactory->addConnection($Connection);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($DbFactory->getManager()->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($DbFactory->getManager())
))
;

return $helperSet;