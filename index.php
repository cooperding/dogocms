<?php
//入口文件
define('SITE_PATH', dirname(__FILE__).'/');
//定义项目名称和路径
define('APP_NAME', 'App');
define('APP_PATH', './App/');
//开启调试模式
define('APP_DEBUG',true);
// 加载框架入口文件
require("./Core/ThinkPHP.php");
?>