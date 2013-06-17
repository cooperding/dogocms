<?php

/**
 * LinkPageAction.class.php
 * 联动模型
 * 核心文件，关联内容模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-2-11 20:09
 * @package  Controller
 * @todo 联动模型其他操作
 */
class LinkPageAction extends BaseAction {

    /**
     * sort
     * 联动分类信息
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
     * 联动分类添加
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
     * 联动分类编辑
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortedit()
    {
        $m = M('LinkpageSort');
        $id = $this->_get('id');
        $condition['id'] = array('eq', $id);
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
     * 联动分类插入
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortinsert()
    {
        $m = M('LinkpageSort');
        $id = $this->_post('id');
        $ename = $this->_post('ename');
        $egroup = $this->_post('egroup');
        $condition['ename'] = array('eq',$ename);
        $condition['egroup'] = array('eq',$egroup);
        $condition['_logic'] = 'OR';
        if (empty($ename) || empty($egroup)) {
            $this->dmsg('1', '请将信息输入完整！', false, true);
        }
        if ($m->field('id')->where($condition)->find()) {
            $this->dmsg('1', '您输入的名称或者标识' . $ename . $egroup . '已经存在！', false, true);
        }
        if ($m->create($_POST)) {
            $rs = $m->add();
            if ($rs) {
                $this->dmsg('2', '分类添加成功！', true);
            } else {
                $this->dmsg('1', '分类添加失败！', false, true);
            }
        } else {
            $this->dmsg('1', '根据表单提交的POST数据创建数据对象失败！', false, true);
        }//if
    }

    /**
     * sortupdate
     * 联动分类更新
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortupdate()
    {
        $m = M('LinkpageSort');
        $id = $this->_post('id');
        $ename = $this->_post('ename');
        $egroup = $this->_post('egroup');
        $where['ename'] = array('eq',$ename);
        $where['egroup'] = array('eq',$egroup);
        $where['_logic'] = 'or';
        $condition['_complex'] = $where;
        $condition['id'] = array('neq', $id);
        if (empty($ename) || empty($egroup)) {
            $this->dmsg('1', '请将信息输入完整！', false, true);
        }
        if ($m->field('id')->where($condition)->find()) {
            $this->dmsg('1', '您输入的名称或者标识' . $ename . $egroup. '已经存在！', false, true);
        }
        $rs = $m->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '未有操作或者操作失败！', false, true);
        }//if
    }

    /**
     * sortdelete
     * 联动分类删除
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortdelete()
    {
        $id = $this->_post('id');
        $m = M('LinkpageSort');
        $M_LinkpageList = M('LinkpageList');
        $condition_link['linkpage_id'] = array('eq', $id);
        $condition['id'] = array('eq', $id);
        if ($M_LinkpageList->field('id')->where($condition_link)->find()) {
            $this->dmsg('1', '列表中存在该分类元素不能删除！', false, true);
        }
        $del = $m->where($condition)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * sortlist
     * 联动列表
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortlist()
    {
        $m = M('LinkpageSort');
        $sort = $m->field('id,ename')->select();
        $this->assign('sort', $sort);
        $this->display();
    }

    /**
     * sortlistsort
     * 联动列表左侧菜单
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortlistsort()
    {//点击左侧信息打开右侧
        $id = $this->_get('id');
        //echo $id;
        $this->assign('id', $id);
        $this->display('sortlisttab');
    }

    /**
     * sortlistadd
     * 联动列表编辑添加
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortlistadd()
    {

        $id = $this->_get('id');
        $this->assign('linkpage_id', $id);
        $this->display();
    }

    /**
     * sortlistedit
     * 联动列表编辑
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortlistedit()
    {
        $id = $this->_get('id');
        $list = M('LinkpageList');
        $condition['id'] = array('eq', $id);
        $data = $list->where($condition)->find();
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * sortlistdelete
     * 联动列表删除
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortlistdelete()
    {
        $m = M('LinkpageList');
        $id = $this->_post('id');
        if (empty($id)) {
            $this->dmsg('1', '未有id值，无法删除！', false, true);
        }
        $condition_path['path'] = array('like','%,' . $id . ',%');
        $data = $m->field('id')->where($condition_path)->select();
        
        if (is_array($data)) {
            $this->dmsg('1', '该分类下还有子级分类，无法删除！', false, true);
        }
        $condition['id'] = array('eq',$id);
        $del = $m->where($condition)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * sortlistinsert
     * 联动列表编辑插入数据
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortlistinsert()
    {
        $m = M('LinkpageList');
        $parent_id = $this->_post('parent_id');
        $_POST['sort_name'] = trim($_POST['sort_name']);
        if (empty($_POST['sort_name'])) {
            $this->dmsg('1', '分类名不能为空！', false, true);
        }
        if ($parent_id != 0) {
            $data = $m->where('id=' . $parent_id)->find();
            $_POST['path'] = $data['path'] . $parent_id . ',';
        }
        if ($m->create($_POST)) {
            $rs = $m->add($_POST);
            if ($rs) {
                $this->dmsg('2', '操作成功！', true);
            } else {
                $this->dmsg('1', '操作失败！', false, true);
            }
        }
    }

    /**
     * sortlistupdate
     * 联动列表编辑更新
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortlistupdate()
    {
        $m = M('LinkpageList');
        $d = D('NewsSort');
        $tbname = 'LinkpageList';
        $linkpage_id = $this->_post('linkpage_id');
        $id = $this->_post('id');
        $parent_id = $this->_post('parent_id');
        if ($parent_id != 0) {//不为0时判断是否为子分类
            $condition_path['linkpage_id'] = array('eq',$linkpage_id);
            $condition_path['id'] = array('eq',$parent_id);
            $condition_path['path'] = array('like','%,' . $id . ',%');
            $cun = $m->field('linkpage_id')->where($condition_path)->find(); //判断id选择是否为其的子类
            if ($cun) {
                $this->dmsg('1', '不能选择当前分类的子类为父级分类！', false, true);
            }
            $condition_parent['id'] = array('eq',$parent_id);
            $data = $m->field('path')->where($condition_parent)->find();
            $sort_path = $data['path'] . $parent_id . ','; //取得不为0时的path
            $_POST['path'] = $data['path'] . $parent_id . ',';
            $d->updatePath($id, $sort_path, $tbname);
        } else {//为0，path为,
            $condition_id['id'] = array('eq',$parent_id);
            $data = $m->field('parent_id')->where($condition_id)->find();
            if ($data['parent_id'] != $parent_id) {//相同不改变
                $sort_path = ','; //取得不为0时的path
                $d->updatePath($id, $sort_path, $tbname);
            }
            $_POST['path'] = ','; //应该是这个
        }
        $rs = $m->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }
    }

    /**
     * sortJson
     * 返回sortJson联动分类数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortJson()
    {
        $m = M('LinkpageSort');
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

    /**
     * sortModelJson
     * 返回sortModelJsonn联动分类数据,模型列表处使用
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortModelJson()
    {
        $m = M('LinkpageSort');
        $list = $m->field('id,ename')->select();
        $array = array();
        foreach ($list as $k => $v) {
            $array[$k] = $v;
        }
        echo json_encode($array);
    }

    /**
     * jsonTreeId
     * 通过id返回jsonTree数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function jsonTreeId()
    {
        Load('extend');
        $m = M('LinkpageList');
        $id = $this->_get('id');
        $condition['linkpage_id'] = array('eq',$id);
        $tree = $m->field(array('id','parent_id','sort_name'=>'text'))->where($condition)->select();
        $tree = list_to_tree($tree, 'id', 'parent_id', 'children');
        //$tree = array_merge(array(array('id' => 0, 'text' => L('sort_root_name'))), $tree);
        echo json_encode($tree);
    }

    /**
     * jsonTreeListId
     * 通过id返回jsonTreeList数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function jsonTreeListId()
    {
        Load('extend');
        $m = M('LinkpageList');
        $id = $this->_get('id');
        $condition['linkpage_id'] = array('eq',$id);
        $tree = $m->field(array('id','parent_id','sort_name'=>'text'))->where($condition)->select();
        $tree = list_to_tree($tree, 'id', 'parent_id', 'children');
        $tree = array_merge(array(array('id' => 0, 'text' => L('sort_root_name'))), $tree);
        echo json_encode($tree);
    }

    /**
     * jsonSortTree
     * 分类树信息json数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function jsonSortTree()
    {
        Load('extend');
        $m = M('LinkpageSort');
        $tree = $m->field(array('id','ename' => 'text'))->select();
        $tree = list_to_tree($tree, 'id', 'parent_id', 'children');
        echo json_encode($tree);
    }

}
?>

