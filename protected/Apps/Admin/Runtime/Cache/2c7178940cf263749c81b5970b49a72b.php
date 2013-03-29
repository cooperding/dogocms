<?php if (!defined('THINK_PATH')) exit();?><form action="__APP__/ContentModel/sortlistupdate" class="form_dogocms" method="post">
    <input type="hidden" name="sort_id" value="<?php echo ($data["sort_id"]); ?>" />
    <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
    <div class="division">
        <table>
            <tbody>
                <tr>
                    <th>表单提示文字：</th>
                    <td><input type="text" name="ename" value="<?php echo ($data["ename"]); ?>" data-options="required:true" class="easyui-validatebox"/><span class="red">*</span></td>
                </tr>
                <tr>
                    <th>字段名称：</th>
                    <td><input type="text" name="emark" value="<?php echo ($data["emark"]); ?>" data-options="required:true" class="easyui-validatebox"/><span class="red">*</span></td>
                </tr>
                <tr>
                    <th>数据类型：</th>
                    <td><input value="<?php echo ($data["etype"]); ?>" name="etype" class="listadd" style="width:200px;"></td>
                </tr>
            <li class="liandong" style="display: none">
            <th>联动分类：</th>
            <td><input value="<?php echo ($data["elink"]); ?>" name="elink" class="modellinkpage" style="width:200px;"></td>
            </tr>
            <tr>
                <th>默认值：</th>
                <td><textarea name="evalue" rows="5" cols="30"><?php echo ($data["evalue"]); ?></textarea><span class="red">*使用英文状态下的逗号分开</span></td>
            </tr>
            <tr>
                <th>最大长度：</th>
                <td><input type="text" name="maxlength" value="<?php echo ($data["maxlength"]); ?>" /><span class="red">*请根据所选的数据类型进行选择</span></td>
            </tr>
            <tr>
                <th><?php echo L("orderby");?>：</th><td><input type="text" name="myorder" value="<?php echo ($data["myorder"]); ?>" /></td>
            </tr>
            </tbody>
        </table></div>
</form>

<script>
    $(function(){
        var elink = '<?php echo ($data["elink"]); ?>';
        if(elink!=0){
            linkpage();
        }
        $('.listadd').combobox({
            url:'__APP__/ContentModel/radioJson',
            valueField:'name',
            textField:'text',
            multiple:false,
            onChange:function(){
                var val = $('.listadd').combobox('getValue');
                if(val =='stepselect'){
                    linkpage();
                }else{
                    $('.liandong').css('display','none');
                    $('.modellinkpage').combobox('setValue','');
                }

            }
        });//end
        function linkpage(){
            $('.liandong').css('display','block');
            $('.modellinkpage').combobox({
                url:'__APP__/LinkPage/sortModelJson',
                valueField:'id',
                textField:'ename',
                multiple:false
            })
        }//fun
    });
</script>