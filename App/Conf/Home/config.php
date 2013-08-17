<?php

defined('THINK_PATH') or exit();
$array = require_once('config.php');
$miniConfig = array(
    'ACCESS' => TRUE,
    //'DEFAULT_THEME' => 'default', //默认模板主题名
    //动态缓存配置
    'DATA_CACHE_TYPE' => 'file', //数据缓存类型 File、APC、Db、Memcache、Shmop、Sqlite、Redis、Eaccelerator和Xcache
    'DATA_CACHE_TIME' => '86400', //3600*24 0为永久
    'DATA_CACHE_SUBDIR' => true, //开启子目录
    'DATA_CACHE_LEVEL' => '3', //设置子目录的层次
    'DATA_CACHE_COMPRESS' => true, //数据缓存是否压缩缓存true false
    'DATA_CACHE_CHECK' => false, //数据缓存是否校验缓存true false
    //数据缓存设置
    //静态缓存设置
    /*
      'HTML_CACHE_ON'=>true,
      'HTML_FILE_SUFFIX'=>'',
      'HTML_CACHE_TIME'=>'',
      'HTML_CACHE_RULES'=>array(),
     * 
     */
    //路由功能设置
    'URL_ROUTER_ON' => true,
    'URL_PATHINFO_DEPR' => '/',
    'URL_HTML_SUFFIX' => 'shtml',
    'URL_MODEL' => 2,
    'URL_CASE_INSENSITIVE' => true,//true不再区分大小写
    'URL_ROUTE_RULES' => array(
        'list/:id'  => 'List/',
        'content/:id'  => 'content/',
        //'comment/:id'  => 'Comment/index',
        //'comment/vercode'  => 'content/vercode',
    )
);
$array = array_merge($array, $miniConfig);
//print_r($miniConfig);

return $array;
?>