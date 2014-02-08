<?php

/**
 * BasehomeAction.class.php
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
class BasehomeAction extends Action {

    //初始化
    function _initialize()
    {
        $skin = $this->getSkin(); //获取前台主题皮肤名称
        $navhead = $this->getNav('header'); //导航菜单
        $this->assign('navhead', $navhead);
        $this->assign('style', __PUBLIC__ . '/Skin/Home/' . $skin);
        $this->assign('style_cmomon', __PUBLIC__ . '/Common');
        $this->assign('header', './App/Tpl/Home/' . $skin . '/header.html');
        $this->assign('footer', './App/Tpl/Home/' . $skin . '/footer.html');
    }

    /*
     * getSkin
     * 获取站点设置的主题名称
     * @todo 使用程序读取主题皮肤名称
     */

    public function getSkin()
    {
        $skin = R('Api/News/getCfg', array('cfg_skin_web'));
        if(!$skin){
            $skin = 'default';
        }
        return $skin;
    }
    /*
     * getNav
     * 获取导航菜单
     * @param string $type header 是头部导航菜单
     * @param string $type footer 是底部导航菜单
     */

    public function getNav($type='header')
    {
        if($type=='header'){
            $m = new NavHeadModel();
        }elseif($type=='footer'){
            $m = new NavFootModel();
        }
        $condition['status'] = array('eq',20);
        $list = $m->where($condition)->select();
        Load('extend');
        $tree = list_to_tree($list, 'id', 'parent_id', 'children');
        return $tree;
    }

}

?>
