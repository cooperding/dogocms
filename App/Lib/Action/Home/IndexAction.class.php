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
class IndexAction extends BasehomeAction {

    public function index()
    {
        import('ORG.Util.Page'); // 导入分页类
        //$count = $t->where($title)->count();
        $Page = new Page($count, 5); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        //$list = $t->where($title)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        
        
        $m = new SettingModel();
        $title['sys_name'] = array('eq','cfg_title');
        $keywords['sys_name'] = array('eq','cfg_keywords');
        $description['sys_name'] = array('eq','cfg_description');
        $data_title = $m->where($title)->find();
        $data_keywords = $m->where($keywords)->find();
        $data_description = $m->where($description)->find();
        
        $skin = $this->getSkin();//获取前台主题皮肤名称
        $this->assign('title',$data_title['sys_value']);
        $this->assign('keywords',$data_keywords['sys_value']);
        $this->assign('description',$data_description['sys_value']);
        $this->display($skin.':index');
    }

}