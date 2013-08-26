<?php

/**
 * AccessModel.class.php
 * 角色与节点对应记录信息表模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-08-26 20:46
 * @package  Controller
 * @todo 字段验证
 */
class AccessModel extends Model {

    protected $tableName = 'access';
    protected $fields = array(
        'role_id', 'node_id', 'level', 'module'
    );

}

?>