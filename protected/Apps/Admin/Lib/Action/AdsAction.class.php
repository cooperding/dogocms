<?php

/**
 * AdsAction.class.php
 * 广告信息
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:08
 * @package  Controller
 * @todo
 */
class AdsAction extends BaseAction {

    /**
     * index
     * 广告列表页
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function index()
    {
        $this->display();
    }

    /**
     * add
     * 添加信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function add()
    {
        $this->display();
    }

    /**
     * edit
     * 编辑信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function edit()
    {
        $this->display();
    }

    /**
     * delete
     * 留言删除
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function delete()
    {
        $id = intval($_POST['id']);
        $m = M('Ads');
        $condition['id'] = array('eq',$id);
        $del = $m->where($condition)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }
    /**
     * sort
     * 广告分类
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sort()
    {
        $this->display();
    }

    /**
     * sortadd
     * 添加广告分类
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortadd()
    {
        $radios = array(
            'y' => '启用',
            'n' => '禁用'
        );
        $this->assign('radios', $radios);
        $this->display();
    }

    /**
     * sortedit
     * 编辑广告分类
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortedit()
    {
        $id = $_GET['id'];
        $m = M('AdsSort');
        $condition['id'] = array('eq',$id);
        $data = $m->where($condition)->find();
        $radios = array(
            'y' => '启用',
            'n' => '禁用'
        );
        $this->assign('radios', $radios);
        $this->assign('v_status', $data['status']);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * sortinsert
     * 写入广告分类
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortinsert()
    {
        $m = M('AdsSort');
        $condition['ename'] = trim($_POST['ename']);
        if (empty($condition['ename'])) {
            $this->dmsg('1', '请将信息输入完整！', false, true);
        }
        $_POST['status'] = $_POST['status']['0'];
        if ($m->create()) {
            $rs = $m->add($_POST);
            if ($rs) {//存在值
                $this->dmsg('2', '操作成功！', true);
            } else {
                $this->dmsg('1', '操作失败！', false, true);
            }
        } else {
            $this->dmsg('1', '根据表单提交的POST数据创建数据对象失败！', false, true);
        }
    }
/**
     * sortupdate
     * 更新广告分类
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortupdate()
    {
        $m = M('AdsSort');
        $id = intval($_POST['id']);
        $condition['ename'] = array('eq',trim($_POST['ename']));
        $condition['id'] = array('neq', $id);
        if (empty($condition['ename'])) {
            $this->dmsg('1', '请将信息输入完整！', false, true);
        }
        if ($m->field('id')->where($condition)->find()) {
            $this->dmsg('1', '您输入的名称' . $condition['ename'] . '已经存在！', false, true);
        }
        $_POST['status'] = $_POST['status']['0'];
        $rs = $m->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }
    /**
     * sortdelete
     * 删除广告分类
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortdelete()
    {
        $m = M('AdsSort');
        $l = M('Ads');
        $id = intval($_POST['id']);
        $condition['sort_id'] = array('eq', $id);
        if ($l->field('id')->where($condition)->find()) {
            $this->dmsg('1', '列表中含有该分类的信息，不能删除！', false, true);
        }
        $del = $m->where('id=' . $id)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }
    /**
     * sortJson
     * 返回sortjson模型分类数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortJson()
    {
        $m = M('AdsSort');
        $list = $m->select();
        $count = $m->count("id");
        $a = array();
        foreach ($list as $k => $v) {
            $a[$k] = $v;
        }
        $array = array();
        $array['total'] = $count;
        $array['rows'] = $a;
        echo json_encode($array);
    }

}

?>