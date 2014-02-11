<?php

//由ThinkPHP工具箱生成的配置文件

defined('THINK_PATH') or exit();
$array = require_once('config.php');
$miniConfig = array(
    'DEBUG_MODE' => false,
    'DEFAULT_ACTION' => 'index',
    'DEFAULT_LANG' => 'zh-cn', //默认语言
    //权限部分
    'AUTH_CONFIG' => array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => C('DB_PREFIX') . 'auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => C('DB_PREFIX') . 'auth_group_access', //用户组明细表
        'AUTH_RULE' => C('DB_PREFIX') . 'auth_rule', //权限规则表
        'AUTH_USER' => C('DB_PREFIX') . 'operators'//用户信息表
    ),
    'ADMINISTRATOR'=>array('1')
);
$array = array_merge((array) $array, (array) $miniConfig);
return $array;
?>