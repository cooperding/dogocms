<?php if (!defined('THINK_PATH')) exit();?><table id="datagrid_settingtab<?php echo ($id); ?>" class="settingtab<?php echo ($id); ?> form_dogocms">
    <thead>
        <tr>
            <th data-options="field:'id',width:180,align:'center'">id</th>
            <th data-options="field:'sys_info',width:180,align:'center'">参数名称</th>
            <th data-options="field:'sys_value',width:450,align:'left'">参数值</th>
            <th data-options="field:'sys_name',width:150,align:'center'">参数变量</th>
        </tr>
    </thead>
</table>
<script>
    $(function(){
        var height = $('.indexcenter').height();
        var classId = 'settingtab<?php echo ($id); ?>';
        var hrefadd = '__APP__/Setting/add?id=<?php echo ($id); ?>';
        var hrefedit = '__APP__/Setting/edit';
        var hrefcancel = '__APP__/Setting/delete';
        var urljson = '__APP__/Setting/fieldJsonId?id=<?php echo ($id); ?>';
        $('.layout_'+classId).css('height',height-50);
        var height = $('.indexcenter').height();
        $('#datagrid_'+classId).datagrid({
            url:urljson,
            idField:'id',
            rownumbers:true,
            fitColumns:true,
            checkbox:true,
            height:height-100,
            singleSelect:true,
            frozenColumns:[[
                    {
                        field:'ck',
                        checkbox:true
                    }
                ]],
            toolbar:[{
                    id:'btnadd_'+classId,
                    text:'添加',
                    iconCls:'icon-add',
                    handler:function(){
                        var title = '添加分类';
                        openDialog(classId,hrefadd,title);
                    }
                },'-',{
                    id:'btnedit_'+classId,
                    text:'编辑',
                    iconCls:'icon-edit',
                    handler:function(){
                        var ids = [];
                        var rows = $('#datagrid_'+classId).datagrid('getSelections');
                        for(var i=0;i<rows.length;i++){
                            ids.push(rows[i].id);
                        }
                        if(ids==''){
                            $.messager.alert('信息提示', '请选择要操作的项', 'error');
                            return false;
                        }else if(rows.length>1){
                            $.messager.alert('信息提示', '请选择一个要操作的项', 'error');
                            return false;
                        }
                        var href = hrefedit+'?id='+ids;
                        var title = '编辑信息';
                        openDialog(classId,href,title);
                    }
                },'-',{
                    id:'btncanel_'+classId,
                    text:'删除',
                    iconCls:'icon-cancel',
                    handler:function(){
                        var selected = $('#datagrid_'+classId).datagrid('getSelected');
                        if(!selected){
                            $.messager.alert('信息提示', '1请选择要操作的项', 'error');
                            return false;
                        }
                        var id = selected.id;
                        var href = hrefcancel;
                        var title = '删除信息';
                        $.messager.confirm(title,href, function(){
                            $.ajax({
                                url:href,
                                type:'post',
                                data:{
                                    id:id
                                },
                                dataType:'json',
                                success:function(data){
                                    formAjax(data,classId);
                                }
                            });
                        });//$
                    }
                }//
            ]//toolbar
        });

    })
</script>