<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
//            'class' => 'yii\redis\Cache',
        ],
//        'redis' => [
//            'class' => 'yii\redis\Connection',
//            'hostname' => '127.0.0.1',
//            'port' => 6379,
//            'database' => 0,
//        ],
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'timeFormat' => 'HH:mm:ss',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss'
        ],
    ],
    'charset' => 'utf-8',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',

];
