<?php

/**
 * AjaxAction.class.php
 * 前台jquery ajax请求处理页
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:08
 * @package  Controller
 * @todo 完善更多方法
 */
class AjaxAction extends BasehomeAction {

    /**
     * vote
     * 投票操作
     * @param string $key_id 信息编号
     * @param string $type 投票类型
     * @param string $uid 会员编号
     * @return boolean
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function vote()
    {
        $t = new TitleModel();
        $ir = new InformationRecordModel();
        $key_id = $this->_post('key_id');
        $type = $this->_post('type');
        $ip = get_client_ip();
        $uid = session('LOGIN_M_ID'); //会员ID
        $data['key_id'] = $key_id;
        $data['type'] = $type;
        $data['ip'] = $ip;
        $data['addtime'] = time();
        $data['updatetime'] = time();
        $data['members_id'] = $uid;
        $rs = $ir->add($data);
        if ($rs == true) {
            $condition['id'] = array('eq', $key_id);
            if ($type == '10') {//up
                $t->where($condition)->setInc('num_top');
                $data_num = $t->field('num_top')->where($condition)->find();
                $num = $data_num['num_top'];
            } elseif ($type == '11') {//down
                $t->where($condition)->setInc('num_beat');
                $data_num = $t->field('num_beat')->where($condition)->find();
                $num = $data_num['num_beat'];
            }
            $array = array('status' => 0, 'msg' => '投票成功', 'num' => $num);
        } else {
            $array = array('status' => 1, 'msg' => '投票失败！');
        }
        echo json_encode($array);
    }

    /**
     * commemt
     * 评论操作
     * @param string $key_id 信息编号
     * @param string $content 评论内容
     * @param string $uid 会员编号
     * @return boolean
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function commemt()
    {
        $t = new TitleModel();
        $c = new CommentModel();
        $key_id = $this->_post('key_id');
        $content = $this->_post('content');
        $ip = get_client_ip();
        $uid = session('LOGIN_M_ID'); //会员ID
        $data['title_id'] = $key_id;
        $data['ip'] = $ip;
        $data['addtime'] = time();
        $data['updatetime'] = time();
        $data['members_id'] = $uid;
        $data['content'] = $content;
        //计算最大值
        $condition_comment['title_id'] = array('eq', $key_id);
        $condition_comment['parent_id'] = array('eq', 0);
        $floor = $c->where($condition_comment)->max('floor');
        $floor = $floor + 1;
        $data['floor'] = $floor;
        $rs = $c->add($data);
        if ($rs == true) {
            $condition['id'] = array('eq', $key_id);
            $t->where($condition)->setInc('num_comment');
            $data_num = $t->field('num_comment')->where($condition)->find();
            $num = $data_num['num_comment'];
            $array = array('status' => 0, 'msg' => '发表评论成功', 'num' => $num);
        } else {
            $array = array('status' => 1, 'msg' => '发表评论失败！');
        }
        echo json_encode($array);
    }

}
