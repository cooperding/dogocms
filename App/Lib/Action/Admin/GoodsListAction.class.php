<?php

/**
 * GoodsListAction.class.php
 * 商品列表信息内容
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-09-02 19:23
 * @package  Controller
 * @todo 信息各项操作
 */
class GoodsListAction extends BaseAction {

    /**
     * index
     * 信息列表
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function index() {
        $this->display();
    }

    /**
     * newslist
     * 信息列表
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function newslist() {
        $id = $this->_get('id');
        $this->assign('id', $id);
        $this->display('newslist');
    }

    /**
     * add
     * 添加信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function add() {
        $id = $this->_get('id');
        $status = array(
            '20' => ' 审核 ',
            '10' => ' 未审核 ',
            '11' => ' 未通过审核 '
        );
        $is_sale = array(
            '20' => ' 是 ',
            '10' => ' 否 '
        );
        $is_recycle = array(
            '20' => ' 是 ',
            '10' => ' 否 '
        );
        $this->assign('id', $id);
        $this->assign('status', $status);
        $this->assign('is_sale', $is_sale);
        $this->assign('is_recycle', $is_recycle);
        $this->display();
    }

    /**
     * edit
     * 编辑信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function edit() {
        $m = new TitleModel();
        $id = $this->_get('id');
        $condition_id['t.id'] = array('eq',$id);
        $data = $m->field(array('t.*','c.content','ms.id' => 'msid','ms.emark' => 'msemaerk'))->Table( C('DB_PREFIX') . 'title t')->join(C('DB_PREFIX') . 'content c ON c.title_id = t.id ')
                        ->join(C('DB_PREFIX') . 'news_sort ns ON ns.id=t.sort_id')->join(C('DB_PREFIX') . 'model_sort ms ON ms.id=ns.model_id')
                        ->where($condition_id)->find();
        $am = M(ucfirst(C('DB_ADD_PREFIX')) . $data['msemaerk']);
        $condition_tid['title_id'] = array('eq',$id);
        $data_ms = $am->where($condition_tid)->find();
        $mf = new ModelFieldModel();
        $condition_sid['sort_id'] = array('eq',$data['msid']);
        $data_filed = $mf->where($condition_sid)->order('myorder asc,id asc')->select();
        foreach ($data_filed as $k => $v) {
            $exp = explode(',', $v['evalue']);
            if ($v['etype'] == 'radio') {
                $data_filed[$k]['opts'] = $exp;
            } elseif ($v['etype'] == 'checkbox') {
                $data_filed[$k]['opts'] = $exp;
            } elseif ($v['etype'] == 'select') {
                $data_filed[$k]['opts'] = $exp;
            }
        }
        $flag = array(
            'h' => ' 头条[h] ',
            'r' => ' 推荐[r] ',
            's' => ' 特荐[s] ',
            't' => ' 置顶[t] ',
            'p' => ' 图片[p] ',
            'j' => ' 跳转[j] '
        );
        $radios = array(
            'y' => ' 审核 ',
            'n' => ' 未审核 ',
            'e' => ' 未通过审核 '
        );
        $this->assign('data', $data);
        $this->assign('filed', $data_filed);
        $this->assign('datafiled', $data_ms);
        $this->assign('flag', $flag);
        $this->assign('radios', $radios);
        $this->assign('v_status', $data['status']);
        $this->display();
    }

    /**
     * insert
     * 写入信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function insert() {
        $t = new TitleModel();
        $c = new ContentModel();
        $ns = new NewsSortModel();
        $title = $this->_post('title');
        $sort_id = $this->_post('sort_id');
        if (empty($title)) {
            $this->dmsg('1', '文章标题不能为空！', false, true);
        }
        if ($sort_id == 0) {
            $this->dmsg('1', '请选择文档分类！', false, true);
        }
        $_POST['flag'] = implode(',', $_POST['flag']);
        $filed = array();
        foreach ($_POST['filed'] as $k => $v) {
            $filed[$k] = $v;
        }
        foreach ($_POST['filedtime'] as $k => $v) {
            $filed[$k] = strtotime($v);
        }
        foreach ($_POST['filedcheckbox'] as $k => $v) {
            $filed[$k] = implode(',', $v);
        }
        //通过取得的栏目id获得模型id，然后通过模型id获得模型的标识名（即表名），通过表名实例化相应的表信息
        $condition_ns['ns.id'] = array('eq',$sort_id);
        $model_rs = $ns->field('ms.emark')->Table(C('DB_PREFIX') . 'news_sort ns')
                        ->join(C('DB_PREFIX') . 'model_sort ms ON ms.id = ns.model_id ')
                        ->where($condition_ns)->find();
        $m = M(ucfirst(C('DB_ADD_PREFIX')) . $model_rs['emark']);
        //开始写入信息
        $_POST['addtime'] = time();
        $_POST['updatetime'] = time();
        $_POST['op_id'] = session('LOGIN_UID');
        $_POST['status'] = $_POST['status']['0'];
        if ($t->create($_POST)) {
            $rs = $t->add($_POST);
            $last_id = $t->getLastInsID();
            if ($rs == true) {
                $_POST['title_id'] = intval($last_id);
                $filed['title_id'] = intval($last_id);
                $rsc = $c->data($_POST)->add();
                $rsm = $m->data($filed)->add();
                if ($rs == true || $rsc == true || $rsm == true) {
                    $this->dmsg('2', ' 操作成功！', true);
                }
            } else {
                $this->dmsg('1', '操作失败！', false, true);
            }
        } else {
            $this->dmsg('1', '根据表单提交的POST数据创建数据对象失败！', false, true);
        }
    }

    /**
     * update
     * 更新信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function update() {
        $t = new TitleModel();
        $c = new ContentModel();
        $ns = new NewsSortModel();
        $id = $this->_post('id');
        $data['id'] = array('eq',$id);
        $cdata['title_id'] = array('eq',$id);
        $title = $this->_post('title');
        $sort_id = $this->_post('sort_id');
        if (empty($title)) {
            $this->dmsg('1', '文章标题不能为空！', false, true);
        }
        if ($sort_id == 0) {
            $this->dmsg('1', '请选择文档分类！', false, true);
        }
        $_POST['flag'] = implode(',', $_POST['flag']);
        $filed = array();
        foreach ($_POST['filed'] as $k => $v) {
            $filed[$k] = $v;
        }
        foreach ($_POST['filedtime'] as $k => $v) {
            $filed[$k] = strtotime($v);
        }
        foreach ($_POST['filedcheckbox'] as $k => $v) {
            $filed[$k] = implode(',', $v);
        }
        //通过取得的栏目id获得模型id，然后通过模型id获得模型的标识名（即表名），通过表名实例化相应的表信息
        $condition_ns['ns.id'] = array('eq',$sort_id);
        $model_rs = $ns->field('ms.emark')->Table(C('DB_PREFIX') . 'news_sort ns')
                        ->join(C('DB_PREFIX') . 'model_sort ms ON ms.id = ns.model_id ')
                        ->where($condition_ns)->find();
        $m = M(ucfirst(C('DB_ADD_PREFIX')) . $model_rs['emark']);
        $_POST['updatetime'] = time();
        $_POST['op_id'] = session('LOGIN_UID');
        $_POST['status'] = $_POST['status']['0'];
        $rs = $t->where($data)->save($_POST);
        $rsc = $c->where($cdata)->save($_POST);
        $rsm = $m->where($cdata)->save($filed);
        if ($rs == true || $rsc == true || $rsm == true) {
            $this->dmsg('2', '更新成功！', true);
        } else {
            $this->dmsg('1', '更新失败,或者未有更新！', false, true);
        }
    }

    /**
     * delete
     * 删除文档到回收站
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function delete() {
        $t = new TitleModel();
        $id = $this->_post('id');
        $data['id'] = array('in', $id);
        if (empty($data['id'])) {
            $this->dmsg('1', '未有id值，操作失败！', false, true);
        }
        $rs = $t->where($data)->setField('is_recycle', 'y');
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * tempmodel
     * 写入信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function tempmodel() {
        $mf = new ModelFieldModel();
        $id = $this->_post('id');
        $condition_sort['sort_id'] = array('eq',$id);
        $data_filed = $mf->where($condition_sort)->order('myorder asc,id asc')->select();
        foreach ($data_filed as $k => $v) {
            $exp = explode(',', $v['evalue']);
            if ($v['etype'] == 'radio') {
                $data_filed[$k]['opts'] = $exp;
            } elseif ($v['etype'] == 'checkbox') {
                $data_filed[$k]['opts'] = $exp;
            } elseif ($v['etype'] == 'select') {
                $data_filed[$k]['opts'] = $exp;
            }
        }
        $this->assign('id', time());
        $this->assign('filed', $data_filed);
        $this->display();
    }

    /**
     * recycle
     * 回收站信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function recycle() {
        $this->display();
    }

    /**
     * recycleRevert
     * 回收站还原信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function recycleRevert() {
        $t = new TitleModel();
        $id = $this->_post('id');
        $data['id'] = array('in', $id);
        if (empty($data['id'])) {
            $this->dmsg('1', '未有id值，操作失败！', false, true);
        }
        $rs = $t->where($data)->setField('is_recycle', 'n');
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * deleteRec
     * 从回收站彻底删除信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function deleteRec() {
        $t = new TitleModel();
        $c = new ContentModel();
        $id = $this->_post('id');
        $data['id'] = array('in', $id);
        $cdata['title_id'] = array('in', $id);
        //id是唯一的值，要取得所有模型的表名，才能删除模型内的信息
        foreach ($id as $k => $v) {
            //通过取得的栏目id获得模型id，然后通过模型id获得模型的标识名（即表名），通过表名实例化相应的表信息
            $model_rs = $t->field('ms.emark')->Table(C('DB_PREFIX') . 'news_sort ns')
                            ->join(C('DB_PREFIX') . 'model_sort ms ON ms.id = ns.model_id ')
                            ->join(C('DB_PREFIX') . 'title t ON t.sort_id = ns.id ')
                            ->where('t.id=' . $v)->find();
            //$sql = $t->getLastSql();
            //$this->dmsg('1', $sql, false, true);
            $m = M(ucfirst(C('DB_ADD_PREFIX')) . $model_rs['emark']);
            $m->where('title_id='.$v)->delete();
        }
        $rst = $t->where($data)->delete();
        $rsc = $c->where($cdata)->delete();
        if ($rst == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * listJsonId
     * 取得field信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function listJsonId() {
        $m = new GoodsListModel();
        $s = new GoodsSortModel();
        import('ORG.Util.Page'); // 导入分页类
        $id = $this->_get('id');
        if ($id != 0) {//id为0时调用全部文档
            $condition_sort['id'] = $id;
            $condition_sort['path'] = array('like', '%,' . $id . ',%');
            $condition_sort['_logic'] = 'OR';
            $data_sort = $s->field('id')->where($condition_sort)->select();
            $sort_id = '';
            foreach ($data_sort as $v) {
                $sort_id .= $v['id'] . ',';
            }
            $sort_id = rtrim($sort_id, ',');
            $condition['sort_id'] = array('in', $sort_id);
        }
        $pageNumber = intval($_REQUEST['page']);
        $pageRows = intval($_REQUEST['rows']);
        $pageNumber = (($pageNumber == null || $pageNumber == 0) ? 1 : $pageNumber);
        $pageRows = (($pageRows == FALSE) ? 10 : $pageRows);

        $condition['is_recycle'] = isset($_GET['is_recycle']) ? '20' : '10';
        $count = $m->where($condition)->count();
        $page = new Page($count, $pageRows);
        $firstRow = ($pageNumber - 1) * $pageRows;
        $data = $m->where($condition)->limit($firstRow . ',' . $pageRows)->order('id desc')->select();
        foreach ($data as $k => $v) {
            $data[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
            if($v['status']=='20'){
                $data[$k]['status'] = '已审核';
            }elseif($v['status']=='10'){
                $data[$k]['status'] = '未审核';
            }elseif($v['status']=='11'){
                $data[$k]['status'] = '<a href="javascript:void(0)" title="驳回" style="color:#F74343;">驳回审核</a>';
            }
             
        }
        $array = array();
        $array['total'] = $count;
        $array['rows'] = $data;
        echo json_encode($array);
    }



    

}