<?php

/**
 * ContentModelAction.class.php
 * 内容模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:23
 * @package  Controller
 * @todo 内容模型各项操作
 */
class ContentModelAction extends BaseAction {

    /**
     * sort
     * 内容模型分类
     * @access public
     * @return 返回页面
     * @version dogocms 1.0
     * @todo 模型各项操作
     */
    public function sort() {
        $this->display();
    }

    /**
     * sortadd
     * 内容模型添加
     * @access public
     * @return 返回页面
     * @version dogocms 1.0
     */
    public function sortadd() {
        $radios = array(
            'y' => '启用',
            'n' => '禁用'
        );
        $this->assign('radios', $radios);
        $this->display();
    }

    /**
     * sortedit
     * 内容模型编辑
     * @access public
     * @return 返回页面
     * @version dogocms 1.0
     */
    public function sortedit() {
        $m = new ModelSortModel();
        $id = $this->_get('id');
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
     * 模型分类插入
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortinsert() {
        $d = new ModelTableModel();
        $m = new ModelSortModel();
        $id = $this->_post('id');
        $ename = $this->_post('ename');
        $emark= $this->_post('emark');
        $condition['ename'] = array('eq',$ename);
        $condition['emark'] = array('eq',$emark);
        $condition['_logic'] = 'OR';
        if (empty($ename) || empty($emark)) {
            $this->dmsg('1', '请将信息输入完整！', false, true);
        }
        if ($m->field('id')->where($condition)->find()) {
            $this->dmsg('1', '您输入的名称或者标识' . $ename . $emark . '已经存在！', false, true);
        }
        $d->addtable($emark); //创建数据表
        if ($m->create()) {
            $_POST['updatetime'] = time();
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
     * 模型分类更新
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortupdate() {
        $m = new ModelSortModel();
        $d = new ModelTableModel();
        $id = $this->_post('id');
        $ename = $this->_post('ename');
        $emark = $this->_post('emark');
        $where['ename'] = array('eq',$ename);
        $where['emark'] = array('eq',$emark);
        $where['_logic'] = 'or';
        $condition['_complex'] = $where;
        $condition['id'] = array('neq', $id);

        if (empty($ename) || empty($emark)) {
            $this->dmsg('1', '请将信息输入完整！', false, true);
        }
        if ($m->field('id')->where($condition)->find()) {
            $this->dmsg('1', '您输入的名称或者标识' . $ename . $emark . '已经存在！', false, true);
        }
        $condition_id['id'] = array('eq',$id);
        $data = $m->field('emark')->where($condition_id)->find();
        if ($data['emark'] != $emark) {
            $d->edittable($data['emark'], $emark);
        }
        $_POST['updatetime'] = time();
        $rs = $m->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * sortdelete
     * 模型分类删除
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortdelete() {
        $d = new ModelTableModel();
        $m = new ModelSortModel();
        $list = new ModelFieldModel();
        $id = $this->_post('id');
        $condition_sort['sort_id'] = array('eq',$id);
        if ($list->field('sort_id')->where($condition_sort)->find()) {
            $this->dmsg('1', '列表中存在该分类元素不能删除！', false, true);
        }
        $condition['id'] = array('eq',$id);
        $rs = $m->field('emark')->where($condition)->find();
        $d->droptable($rs['emark']);
        $del = $m->where($condition)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * sortlist
     * 内容模型字段列表
     * @access public
     * @return 返回页面
     * @version dogocms 1.0
     * @todo 模型各项操作
     */
    public function sortlist() {
        $m = new ModelSortModel();
        $sort = $m->field('id,ename')->select();
        $this->assign('sort', $sort);
        $this->display();
    }

    /**
     * sortlistsort
     * 模型列表左侧菜单
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortlistsort() {//点击左侧信息打开右侧
        $id = $this->_get('id');
        $this->assign('id', $id);
        $this->display('sortlisttab');
    }

    /**
     * sortlistadd
     * 模型列表编辑添加
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortlistadd() {
        $id = $this->_get('id');
        $this->assign('id', $id);
        $this->display();
    }

    /**
     * sortlistedit
     * 模型列表编辑
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortlistedit() {
        $list = new ModelFieldModel();
        $id = $this->_get('id');
        $condition['id'] = array('eq',$id);
        $data = $list->where($condition)->find();
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * sortlistinsert
     * 模型列表插入数据
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortlistinsert() {
        $m = new ModelFieldModel();
        $ms = new ModelSortModel();
        $sort_id = $this->_post('sort_id');
        if (empty($_POST['ename']) || empty($_POST['emark'])) {
            $this->dmsg('1', '名称和标识不能为空！', false, true);
        }
        $ename = $this->_post('ename');
        $emark = $this->_post('emark');
        $condition['emark'] = array('eq','d'.$emark);
        $condition['sort_id'] = array('eq', $sort_id);

        if ($m->field('id')->where($condition)->find()) {
            $this->dmsg('1', '您输入的名称或者标识' . $emark . '已经存在！', false, true);
        }
        
        $condition_sort['id'] = array('eq',$sort_id);
        $data = $ms->field('emark')->where($condition_sort)->find();
        $tablename = $data['emark'];
        $d = new ModelTableModel();
        $field = $_POST['emark'];
        $type = $_POST['etype'];
        $length = trim($_POST['maxlength']);
        $d->addfield($tablename, $field, $type, $length);
        $_POST['updatetime'] = time();
        if ($m->create($_POST)) {
            $rs = $m->add($_POST);
            if ($rs) {
                $this->dmsg('2', '操作成功！', true);
            } else {
                $this->dmsg('1', '操作失败！', false, true);
            }
        }//if
    }

    /**
     * sortlistupdate
     * 模型列表更新数据
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortlistupdate() {
        $m = new ModelFieldModel();
        $id = $this->_post('id');
        $sort_id = $this->_post('sort_id');
        $ename = $this->_post('ename');
        $emark = $this->_post('emark');
        if (empty($ename) || empty($emark)) {
            $this->dmsg('1', '名称和标识不能为空！', false, true);
        }
        $condition['id'] = array('neq', $id);
        $condition['emark'] = array('eq','d'.$emark);
        $condition['sort_id'] = array('eq', $sort_id);

        if ($m->field('id')->where($condition)->find()) {
            $this->dmsg('1', '您输入的名称或者标识' . $emark . '已经存在！', false, true);
        }
        $ms = M('ModelSort');
        $condition_sort['id'] = array('eq',$sort_id);
        $data = $ms->field('emark')->where($condition_sort)->find();
        $tablename = $data['emark']; //表名
        $condition_id['id'] = array('eq',$id);
        $field = $m->field('emark')->where($condition_id)->find();
        $oldfield = $field['emark']; //旧字段名
        $d = new ModelTableModel();

        $newfield = $emark; //新字段名
        $type = $this->_post('etype');
        $length = $this->_post('maxlength');
        $d->editfield($tablename, $newfield, $oldfield, $type, $length);
        $_POST['updatetime'] = time();
        $rs = $m->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * sortlistdelete
     * 模型列表删除
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortlistdelete() {
        $id = intval($_POST['id']);
        $m = new ModelFieldModel();
        $d = new ModelTableModel();
        $id = $this->_post('id');
        $condition['mf.id'] = array('eq',$id);
        $data = $m->Table(C('DB_PREFIX') . 'model_field mf')
                ->join(C('DB_PREFIX') . 'model_sort ms on  ms.id=mf.sort_id')
                ->where($condition)
                ->field(array('ms.emark'=>'tbname', 'mf.emark' => 'tbfield'))->find();
        $tablename = $data['tbname'];
        $field = $data['tbfield'];
        if (empty($tablename) || empty($field)) {
            $this->dmsg('1', '操作失败！', false, true);
        }
        $d->detelefield($tablename, $field);
        $condition_id = array('eq',$id);
        $del = $m->where($condition_id)->delete();
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
    public function sortJson() {
        $m = new ModelSortModel();
        $list = $m->select();
        $count = $m->count("id");
        $a = array();
        foreach ($list as $k => $v) {
            $a[$k] = $v;
            if($v['status']=='y'){
                $a[$k]['status'] = '启用';
            }else{
                $a[$k]['status'] = '禁用';
            }
        }
        $array = array();
        $array['total'] = $count;
        $array['rows'] = $a;
        echo json_encode($array);
    }

    /**
     * sortSortJson
     * 返回sortSortJson文档分类模型分类数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortSortJson() {
        $m = new ModelSortModel();
        $list = $m->field(array('id','ename'=>'text'))->order('myorder desc,id asc')->select();
        $list = array_merge(array(array('id' => 0, 'text' => L('modelsort_root_name'))), $list);
        echo json_encode($list);
    }

    /**
     * radioJson
     * 返回radioJson数据类型
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function radioJson() {
        $radio = array(
            array('name' => 'varchar', 'text' => '单行文本(varchar)'),
            array('name' => 'textarea', 'text' => '多行文本'),
            array('name' => 'htmltext', 'text' => 'HTML文本'),
            array('name' => 'int', 'text' => '整数类型'),
            array('name' => 'double', 'text' => '小数类型'),
            array('name' => 'datetime', 'text' => '时间类型'),
            array('name' => 'images', 'text' => '图片'),
            array('name' => 'media', 'text' => '多媒体文件'),
            array('name' => 'addon', 'text' => '附件类型'),
            array('name' => 'select', 'text' => '使用option下拉框'),
            array('name' => 'radio', 'text' => '使用radio选项卡'),
            array('name' => 'checkbox', 'text' => 'Checkbox多选框'),
            array('name' => 'stepselect', 'text' => '联动类型')
        );
        echo json_encode($radio);
    }

    /**
     * fieldJsonId
     * 返回fieldJsonId字段信息数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function fieldJsonId() {
        $m = new ModelFieldModel();
        $id = $this->_get('id');
        $condition['sort_id'] = array('eq',$id);
        $list = $m->field(array('id','ename','emark','etype','elink'))->where($condition)->select();
        $count = $m->where($condition)->count("id");
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
     * jsonSortTree
     * 分类树信息json数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function jsonSortTree() {
        Load('extend');
        $m = new ModelSortModel();
        $tree = $m->field(array('id','ename'=>'text'))->select();
        $tree = list_to_tree($tree, 'id', 'parent_id', 'children');
        //$tree = array_merge(array(array('id' => 0, 'text' => '全部文档')), $tree);
        echo json_encode($tree);
    }

}
?>

