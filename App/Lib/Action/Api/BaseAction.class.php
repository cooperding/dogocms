<?php

/**
 * BaseAction.class.php
 * Api公共方法
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-11-5 11:08
 * @package  Controller
 * @todo 完善更多方法
 */
class BaseAction extends Action {
    /*
     * _initialize
     * 
     * @todo 判断获取数据的权限
     */

    public function _initialize()
    {
        //$api = $this->_get(); //API 签名、密码
        //$key = $this->_get(''); //API Keys密钥（当做常量）
        
    }

}

?>
