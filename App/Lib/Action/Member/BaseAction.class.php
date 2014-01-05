<?php

/**
 * BaseAction.class.php
 * 前台页面公共方法
 * 前台核心文件，其他页面需要继承本类方可有效
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:08
 * @package  Controller
 * @todo 完善更多方法
 */
//if(!C("ACCESS"))exit('Access Denied!');//猜一猜有什么用
class BaseAction extends Action {

    //初始化
    function _initialize()
    {
        //此处判断是否已经登录，如果登录跳转到后台首页否则跳转到登录页面
        $status = session('LOGIN_M_STATUS');
        if ($status != 'TRUE') {
            $this->redirect('..'.__GROUP__.'/Passport/login');
        }
        $skin = $this->getSkin(); //获取前台主题皮肤名称
        $this->assign('style', __PUBLIC__ . '/Skin/Member/' . $skin);
        $this->assign('style_cmomon', __PUBLIC__ . '/Common');
        $this->assign('header', './App/Tpl/Member/' . $skin . '/header.html');
        $this->assign('footer', './App/Tpl/Member/' . $skin . '/footer.html');
    }

    /*
     * getSkin
     * 获取站点设置的主题名称
     * @todo 使用程序读取主题皮肤名称
     */

    public function getSkin()
    {
        $skin = trim($this->getCfg('cfg_member_skin'));
        return $skin;
    }

    /*
     * getCfg
     * 获取站点配置
     * @todo
     */

    public function getCfg($name)
    {
        $m = M('Setting');
        if ($name) {
            $condition['sys_name'] = array('eq', $name);
            $rs = $m->where($condition)->find();
            if ($rs) {
                return $rs['sys_value'];
            } else {
                return 'default';
            }
        } else {
            return false;
        }
    }

}

?>
