<?php

/**
 * NodeModel.class.php
 * 节点信息表模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-08-26 20:54
 * @package  Controller
 * @todo 字段验证
 */
class NodeModel extends Model {

    protected $tableName = 'node';
    //_pk 表示主键字段名称 _autoinc 表示主键是否自动增长类型
    protected $fields = array(
        'id', 'name', 'title', 'status', 'remark', 'sort','pid','level','path','_pk' => 'id', '_autoinc' => true
    );

}

?>