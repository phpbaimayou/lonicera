<?php
/**
 * 配置文件页
 * 以数组的形式保存配置的参数
 */
return $_config = [
    'mode' => 'debug',  //应用模式，默认为调试模式
    'filter' => 'true', //是否过滤 $_GET,$_POST,$_COOKIE,$_FILES
    'charSet' => 'utf-8',   //设置网页编码
    'route'=> [
        'defaultApp' => 'front',    //设置默认分组
        'defaultController' => 'index',  //设置默认控制器
        'defaultAction' => 'index',    //设置默认动作
        'defaultService' => 'index',    //设置默认模型
        'UrlControllerName' => 'c', //自定义控制器名称
        'UrlActionName' => 'a', //自定义方法名称
        'UrlGroupName' => 'g', //自定义分组名称
    ],
    'db' => [
        'database' => 'mysql',
        'ip' => '127.0.0.1',
        'port' => 3306,
        'username' => 'root',
        'password' => 'root',
        'dbName' => 'lonicera'
    ],
    'smtp' => [],
    //数据库配置文件
];