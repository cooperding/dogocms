<?php

/**
 * FlashModel.class.php
 * 文章标题信息表模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-08-18 14:00
 * @package  Controller
 * @todo 字段验证
 */
class FlashModel extends Model {

    protected $tableName = 'flash';
    //_pk 表示主键字段名称 _autoinc 表示主键是否自动增长类型
    protected $fields = array(
        'id', 'sort_id', 'ename', 'eurl', 'epic', 'myorder', 'status', 'emark','addtime','updatetime','_pk' => 'id', '_autoinc' => true
    );

}

?>