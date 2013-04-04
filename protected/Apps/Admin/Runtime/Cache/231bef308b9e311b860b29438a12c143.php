<?php if (!defined('THINK_PATH')) exit();?><table id="datagrid_pages">

    </table>
    <script>
        $(function(){
            var classId = 'pages';
            var urljson = '__APP__/Pages/jsonList';
            var hrefadd = '__APP__/Pages/add';
            var hrefedit = '__APP__/Pages/edit';
            var hrefcancel = '__APP__/Pages/delete';
            openDatagrid(classId,urljson,hrefadd,hrefedit,hrefcancel);
            $('#datagrid_'+classId).datagrid({
                columns:[[
                        {field:'id',title:'ID',width:50,align:'center'},
                        {field:'ename',title:'文档名称',width:200},
                        {field:'addtime',title:'添加时间',width:200},
                        {
                        field:'action',
                        title:'操作',
                        width:50,
                        formatter : function(value, row, index) {
                            return '<img class="btn_do" src="__PUBLIC__/Easyui/themes/icons/search.png" onclick="ding_views(\''+row.id+'\')" title="预览"/>&nbsp;\n\
                    <img class="btn_do" src="__PUBLIC__/Easyui/themes/icons/pencil.png" onclick="ding_edit(\''+hrefedit+'?id='+row.id+'\',\''+classId+'\')"  title="编辑"/>&nbsp;\n\
<img class="btn_do" src="__PUBLIC__/Easyui/themes/icons/cancel.png" onclick="ding_cancel(\''+row.id+'\',\''+hrefcancel+'\',\''+classId+'\')" title=" 删除"/>&nbsp;';
                        }
                    }
                    ]]
            })
        })
    </script>