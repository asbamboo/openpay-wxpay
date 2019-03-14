作为支付渠道扩展使用的安装说明
=================================

根据 `asbamboo/openpay`_ 的文档说明，安装和配置 asbamboo/openpay-wxpay 模块。

在你的项目根目录下创建或修改composer.json文件

::

    {
        ...
        
        "require": {
            ...
             
            "asbamboo/openpay-wxpay": "^1.0",

            ...
        },
        "scripts": {
            "openpay-scripts": [
                "asbamboo\\openpay\\script\\Channel::generateMappingInfo"
            ],
            "post-install-cmd": [
                "@openpay-scripts"
            ],
            "post-update-cmd": [
                "@openpay-scripts"
            ]
        },
        
        ...
    }
    
* require：需要添加对asbamboo/openpay-wxpay模块的依赖
* scripts：用来生成支付渠道映射文件

composer.json 文件修改后需要执行 composer update 使之生效

::

    composer update

.. _asbamboo/openpay: http://www.github.com/asbamboo/openpay