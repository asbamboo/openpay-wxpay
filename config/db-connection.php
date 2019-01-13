<?php
use asbamboo\database\Connection;

/**
 * 数据库信息配置
 */
$sqpath             = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'var', 'data', 'db.sqlite']);
$sqmetadata         = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'asbamboo', 'openpay', 'config', 'database', 'entity']);
$sqmetadata_type    = Connection::MATADATA_YAML;
$sqdir              = dirname($sqpath);

if(!is_file($sqpath)){
    @mkdir($sqdir, 0744, true);
    @file_put_contents($sqpath, '');
}

return Connection::create([
    'driver'    => 'pdo_sqlite',
    'path'      => $sqpath
], $sqmetadata, $sqmetadata_type);
