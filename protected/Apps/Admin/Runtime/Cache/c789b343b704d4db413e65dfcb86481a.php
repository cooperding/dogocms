<?php if (!defined('THINK_PATH')) exit();?><form action="__APP__/Setting/insert" class="form_dogocms" method="post">
    <div class="division">
        <table>
            <tbody>
                <tr>
                    <th>变量名：</th>
                    <td><input type="text" name="sys_name" value="" data-options="required:true" class="easyui-validatebox"/><span class="red">*请以 cfg_ 开头</span></td>
                </tr>
                <tr>
                    <th>所属分组：</th>
                    <td>
                        <input name="parent_id" class="easyui-combotree combotree" data-options="url:'__APP__/Setting/jsonTree',required:true," style="width:200px;"/>
            <select id="" name="sys_gid" onchange="" ondblclick="" class="" ><option value="" >请选择所属分组</option><?php  foreach($select as $key=>$val) { ?><option value="<?php echo $key ?>"><?php echo $val ?></option><?php } ?></select></td>
            </tr>
            <tr>
                <th>变量类型：</th>
                <td><input type="radio" checked="checked" name="sys_type[]" value="text">文本<input type="radio" name="sys_type[]" value="radio">布尔型<input type="radio" name="sys_type[]" value="textarea">多行文本</td>
            </tr>
            <tr>
                <th>参数值：</th><td><textarea name="sys_value" rows="3" cols="30"></textarea><span class="red">*选择布尔值输入否：1/是：2</span></td>
            </tr>
            <tr>
                <th>参数说明;</th><td><input type="text" name="sys_info" value="" /></td>
            </tr>
            <tr>
                <th>排序：</th><td><input type="text" name="myorder" value="" /></td>
            </tr>
            </tbody>
        </table></div>
</form>