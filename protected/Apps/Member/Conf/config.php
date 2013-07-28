<?php

defined('THINK_PATH') or exit();
$array = require_once(dirname(THINK_PATH) . '/Config/config.php');
$miniConfig = array(
    'LANG_SWITCH_ON' => True,
    'DEBUG_MODE' => false,
    'DEFAULT_ACTION' => 'index',
    'DEFAULT_THEME' => 'default', //默认模板主题名
    //'TAGLIB_PRE_LOAD'           =>  'html,dogocms',
    'LANG_SWITCH_ON' => true,
    'DEFAULT_LANG' => 'zh-cn',
    'LANG_AUTO_DETECT' => false,
    'URL_MODEL ' =>2
);

//define(WWW_PATH,dirname(dirname(dirname(dirname(__FILE__)))) . '/');
//echo $array['DB_PREFIX'];
//exit;
$array = array_merge($array, $miniConfig);
return $array;
?>