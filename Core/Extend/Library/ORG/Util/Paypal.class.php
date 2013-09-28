<?php
/**
 * paypal class file
 *
 * 第三方支付paypal类
 * 注：快捷EC支付
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-09-21 19:00
 * @package  Controller
 */

class Paypal {

    /**
     * 汉字ASCII码库
     *
     * @var array
     */
    protected $lib;


    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * 将ASCII编码转化为字符串.
     *
     * @param integer $num
     * @return string
     */
    

    /**
     * 析构函数
     *
     * @access public
     * @return void
     */
    public function __destruct(){

        if (isset($this->lib)) {
            unset($this->lib);
        }
    }
}