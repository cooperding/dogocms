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
        $m = new MembersModel();
        $uid = session('LOGIN_M_ID');
        $condition['id'] = array('eq',$uid);
        $data = $m->field('username,sex,signature,birthday')->where($condition)->find();
        $skin = $this->getSkin(); //获取前台主题皮肤名称
        $this->assign('title', '个人资料');
        $this->assign('sidebar_active', 'personal');
        $this->assign('data', $data);
        $this->display($skin . ':personal');
    }

    /**
     * personal
     * 个人资料
     * @return display
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function email()
    {
        $m = new MembersModel();
        $uid = session('LOGIN_M_ID');
        $condition['id'] = array('eq',$uid);
        $data = $m->field('email,email_status')->where($condition)->find();
        $skin = $this->getSkin(); //获取前台主题皮肤名称
        $this->assign('title', '个人资料');
        $this->assign('sidebar_active', 'email');
        $this->assign('data', $data);
        $this->display($skin . ':email');
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
     * doPersonal
     * 更新个人资料
     * @return display
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function doPersonal()
    {
        $m = new MembersModel();
        $uid = session('LOGIN_M_ID');
        $condition['id'] = array('eq',$uid);
        $data['updatetime'] = time();
        $data['sex'] = $this->_post('sex');
        $data['birthday'] = strtotime($this->_post('birthday'));
        $data['signature'] = $this->_post('signature');
        $rs = $m->where($condition)->save($data);
        if ($rs == true) {
            $this->success('操作成功', __GROUP__ . '/Index/personal');
        } else {
            $this->error('操作失败，请重新操作！');
        }
    }

    /**
     * doEmail
     * 更新邮箱
     * @return display
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function doEmail()
    {
        $m = new MembersModel();
        $uid = session('LOGIN_M_ID');
        $condition['id'] = array('eq',$uid);
        $data['updatetime'] = time();
        $data['email'] = $this->_post('email');
        $condition_email['email'] = array('eq',$data['email']);
        $condition_email['id'] = array('neq',$uid);
        //判断该邮箱是否存在
        $data_email = $m->where($condition_email)->find();
        if($data_email){
            $this->error('您要更改的邮箱已存在，请重新操作！');
            exit();
        }
        $data_one = $m->field('email')->where($condition)->find();
        if($data_one['email']!=$data['email']){
            unset($data['email']);
            $data['email_status'] = 10;
        }
        $rs = $m->where($condition)->save($data);
        if ($rs == true) {
            $this->success('操作成功', __GROUP__ . '/Index/email');
        } else {
            $this->error('操作失败，请重新操作！');
        }
        
        
    }
    /**
     * authEmail
     * 发送验证邮箱信息
     * @return display
     * @version dogocms 1.0
     * @todo 调用邮件接口
     */
    public function authEmail()
    {
        $array = array('status'=>1,'msg'=>'ceshi');
        echo json_encode($array);
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
        $m = new MembersModel();
        $uid = session('LOGIN_M_ID');
        $uname = session('LOGIN_M_NAME');
        $oldpwd = $this->_post('oldpwd'); //原密码
        $newpwd = $this->_post('newpwd'); //新密码1
        $newpwd2 = $this->_post('newpwd2'); //新密码2
        if (empty($oldpwd) || empty($newpwd) || empty($newpwd2)) {
            $this->error('密码项不能为空！');
            exit;
        }
        if($newpwd!=$newpwd2){
            $this->error('两次新密码输入不正确！');
            exit;
        }
        $condition['id'] = array('eq',$uid);
        $data_find = $m->field('password')->where($condition)->find();
        $oldpwd = R('Api/News/getPwd', array($uname, $oldpwd));
        if($oldpwd!=$data_find['password']){
            $this->error('原密码输入不正确，请重新输入！');
            exit;
        }
        $password = R('Api/News/getPwd', array($uname, $newpwd));
        $data['password'] = $password;
        $data['updatetime'] = time();
        $rs = $m->where($condition)->save($data);
        if ($rs == true) {
            $this->success('操作成功', __GROUP__ . '/Index/changePwd');
        } else {
            $this->error('操作失败，请重新操作！');
        }
    }

}
