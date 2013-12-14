<?php

defined('THINK_PATH') or exit();

$connection = array(
    // 数据库常用配置
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 数据库服务器地址
    'DB_NAME' => 'dogocms', // 数据库名
    'DB_USER' => 'root', // 数据库用户名
    'DB_PWD' => 'root', // 数据库密码
    'DB_PORT' => 3306, // 数据库端口
    'DB_PREFIX' => 'ding_', // 数据库表前缀（因为漫游的原因，数据库表前缀必须写在本文件）
    'DB_CHARSET' => 'utf8', // 数据库编码
    'DB_FIELDS_CACHE' => true, // 启用字段缓存
    'URL_ROUTER_ON' => false,
    'URL_CASE_INSENSITIVE' =>true,//url不区分大小写
    //language
    'LANG_SWITCH_ON' => true,
    'LANG_LIST' => 'en-us,zh-cn', // 允许切换的语言列表 用逗号分隔
    'LANG_AUTO_DETECT' => false,
    'VAR_LANGUAGE' => 'l', // 默认语言切换变量
    
    'APP_GROUP_LIST' => 'Home,Admin,Member,Api,B2c', //项目分组设定
    'DEFAULT_GROUP' => 'B2c', //默认分组
    // 是否开启调试模式 (开启AllInOne模式时该配置无效, 将自动置为false)
    //'APP_DEBUG'			=> false,
    'URL_MODEL' => '2',
    'URL_HTML_SUFFIX' => 'html',
    'DB_ADD_PREFIX' => 'add', //内容模型自定义表前缀
    'TAGLIB_BUILD_IN' => 'cx,html',
    'TAGLIB_PRE_LOAD' => 'cx,html,dogocms', //扩展标签
    'DEFAULT_CHARSET' => 'utf8', //默认输出编码
    'DEFAULT_TIMEZONE' => 'PRC', //默认时区
        // 'APP_AUTOLOAD_PATH'=>'@.TagLib,COM.TagLib'
);
return $connection;