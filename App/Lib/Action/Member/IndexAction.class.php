<?php

/**
 * IndexAction.class.php
 * 前台首页
 * 前台核心文件，其他页面需要继承本类方可有效
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:08
 * @package  Controller
 * @todo 完善更多方法
 */
class IndexAction extends BasememberAction {

    /**
     * index
     * 会员主页信息
     * @return boolean
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function index()
    {
        $m = M('Setting');

        $title['sys_name'] = array('eq', 'cfg_title');
        $keywords['sys_name'] = array('eq', 'cfg_keywords');
        $description['sys_name'] = array('eq', 'cfg_description');
        $data_title = $m->where($title)->find();
        $data_keywords = $m->where($keywords)->find();
        $data_description = $m->where($description)->find();

        $Cache = Cache::getInstance(C('DATA_CACHE_TYPE'), array('expire' => C('DATA_CACHE_TIME')));
        $title = $Cache->get('title');
        if (empty($title)) {
            $title['sys_name'] = array('eq', 'cfg_title');
            $data_title = $m->where($title)->find();
            $Cache->set('title', $data_title['sys_value']);
            $title = $data_title['sys_value'];
        }
        $skin = $this->getSkin(); //获取前台主题皮肤名称
        $this->assign('title', '会员中心');
        $this->assign('sidebar_active', 'index');
        $this->display($skin . ':index');
    }

    /**
     * personal
     * 个人资料
     * @return display
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function personal()
    {
        
        $skin = $this->getSkin(); //获取前台主题皮肤名称
        $this->assign('title', '个人资料');
        $this->assign('sidebar_active', 'personal');
        $this->display($skin . ':personal');
    }
    /**
     * changePwd
     * 修改密码
     * @return display
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function changePwd()
    {
        
        $skin = $this->getSkin(); //获取前台主题皮肤名称
        $this->assign('title', '修改密码');
        $this->assign('sidebar_active', 'changepwd');
        $this->display($skin . ':changepwd');
    }
     /**
     * doChangePwd
     * 更新密码
     * @return display
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function doChangePwd()
    {
        $oldpwd = $this->_post('oldpwd');//原密码
        $newpwd = $this->_post('newpwd');//新密码1
        $newpwd2 = $this->_post('newpwd2');//新密码2
        if(empty($oldpwd)||empty($newpwd)||empty($newpwd2)){
            $this->error('密码项不能为空！');
            exit;
        }
    }
    

}
