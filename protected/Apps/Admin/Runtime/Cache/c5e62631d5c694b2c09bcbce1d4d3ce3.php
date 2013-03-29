<?php if (!defined('THINK_PATH')) exit();?><form action="__APP__/News/update" class="form_dogocms" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
    <script charset="utf-8" src="__PUBLIC__/Kindeditor/kindeditor-min.js"></script>
    <div class="division">
        <table>
            <tbody>
                <tr>
                    <th>文档标题：</th>
                    <td><input type="text" name="title" value="<?php echo ($data["title"]); ?>" data-options="required:true" class="easyui-validatebox"/><span class="red">*</span></td>
                </tr>
                <tr>
                    <th>标题颜色：</th>
                    <td>
                        <input type="text" id="color" name="sys_name" value="<?php echo ($data["sys_name"]); ?>"/>
                        <input type="button" id="colorpicker" value="打开取色器" />
                    </td>
                </tr>
                <tr>
                    <th>文档副标题：</th>
                    <td><input type="text" name="subtitle" value="<?php echo ($data["subtitle"]); ?>" /></td>
                </tr>
                <tr>
                    <th>文档属性：</th>
                    <td>
            <?php $arr = explode(',',$data['flag']); foreach($flag as $k=>$v){ if(in_array($k,$arr)){ echo '<input name="flag[]" type="checkbox" value="'.$k.'" checked="checked"/>'.$v; }else{ echo '<input name="flag[]" type="checkbox" value="'.$k.'"/>'.$v; } } ?>
            </td>
            </tr>
            <tr>
                <th>文档分类：</th>
                <td><input name="sort_id" id="sort_combotree" value="<?php echo ($data["sort_id"]); ?>"  style="width:200px;" /><span class="red">*请先选择文档分类</span></td>
            </tr>
            <tr>
                <th>文档标题图：</th>
                <td>
                    <input type="text" id="url1" name="titlepic" value="<?php echo ($data["titlepic"]); ?>" />
                    <input type="button" id="image1" value="选择图片" />
                </td>
            </tr>
            <tr>
                <th>编辑：</th>
                <td><input type="text" name="editor" value="<?php echo ($data["editor"]); ?>" /></td>
            </tr>
            <tr>
                <th>作者：</th>
                <td><input type="text" name="author" value="<?php echo ($data["author"]); ?>" /></td>
            </tr>
            <tr>
                <th>来源：</th>
                <td><input type="text" name="source" value="<?php echo ($data["source"]); ?>" /></td>
            </tr>
            <tr>
                <th>来源网址：</th>
                <td><input type="text" name="sourceurl" value="<?php echo ($data["sourceurl"]); ?>" /></td>
            </tr>
            <tr>
                <th>关键词：</th>
                <td><input type="text" name="keywords" value="<?php echo ($data["keywords"]); ?>" /></td>
            </tr>
            <tr>
                <th>描述简介：</th>
                <td><textarea name="description" rows="3" cols="30"><?php echo ($data["description"]); ?></textarea></td>
            </tr>
            <tr>
                <th>发布时间：</th>
                <td><?php echo (date("Y-m-d H:i:s",$data["addtime"])); ?></td>
            </tr>
            <tr>
                <th>更新时间：</th>
                <td><?php echo (date("Y-m-d H:i:s",$data["updatetime"])); ?></td>
            </tr>
            <tr>
                <th>审核状态：</th>
                <td></td>
            </tr>
            <tr>
                <th>文档内容：</th>
                <td>
                    <textarea id="content" name="content" style="width:720px;height:400px;visibility:hidden;"><?php echo (stripslashes($data["content"])); ?></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="conModel" style="margin: 10px 0;"><div class="division">
        <table>
            <tbody>
    <?php if(is_array($filed)): foreach($filed as $key=>$vo): ?><tr>
            <th><?php echo ($vo["ename"]); ?>：</th><td>
        <?php if($vo["etype"] == 'varchar'): ?><input type="text" name="filed[<?php echo ($vo["emark"]); ?>]" value="<?php echo ($datafiled[$vo['emark']]); ?>" />
            <?php elseif($vo["etype"] == 'textarea'): ?>
            <textarea name="filed[<?php echo ($vo["emark"]); ?>]" rows="3" cols="30"><?php echo ($datafiled[$vo['emark']]); ?></textarea>
            <?php elseif($vo["etype"] == 'htmltext'): ?>
            <script>
                $(function() {
                    KindEditor.create('#content_<?php echo ($vo["emark"]); ?>', {
                        themeType : 'simple',
                        allowFileManager : true,
                        uploadJson:'__APP__/Upload/uploadImg',
                        fileManagerJson :'__APP__/Upload/fileManagerJson',
                        afterBlur : function() {
                            this.sync();
                        }
                    });
                });
            </script>
            <textarea id="content_<?php echo ($vo["emark"]); ?>" name="filed[<?php echo ($vo["emark"]); ?>]" style="width:720px;height:400px;visibility:hidden;"><?php echo (stripslashes($datafiled[$vo['emark']])); ?></textarea>
            <?php elseif($vo["etype"] == 'int'): ?>
            <input type="text" name="filed[<?php echo ($vo["emark"]); ?>]" value="<?php echo ($datafiled[$vo['emark']]); ?>" />
            <?php elseif($vo["etype"] == 'double'): ?>
            <input type="text" name="filed[<?php echo ($vo["emark"]); ?>]" value="<?php echo ($datafiled[$vo['emark']]); ?>" />
            <?php elseif($vo["etype"] == 'datetime'): ?>
            <input type="text" class="easyui-datetimebox" data-options="required:true,showSeconds:false" name="filedtime[<?php echo ($vo["emark"]); ?>]" value="<?php echo (date('Y-m-d H:i:s',$datafiled[$vo['emark']])); ?>" />
            <?php elseif($vo["etype"] == 'images'): ?>
            <script>
                $(function() {
                    var editor = KindEditor.editor({
                        allowFileManager : true,
                        uploadJson:'__APP__/Upload/uploadImg',
                        fileManagerJson :'__APP__/Upload/fileManagerJson'
                    });
                    KindEditor('#image_<?php echo ($vo["emark"]); ?>').click(function() {
                        editor.loadPlugin('image', function() {
                            editor.plugin.imageDialog({
                                imageUrl : KindEditor('#url_<?php echo ($vo["emark"]); ?>').val(),
                                clickFn : function(url, title, width, height, border, align) {
                                    KindEditor('#url_<?php echo ($vo["emark"]); ?>').val(url);
                                    editor.hideDialog();
                                }
                            });
                        });
                    });
                });
            </script>
            <input type="text" id="url_<?php echo ($vo["emark"]); ?>" name="filed[<?php echo ($vo["emark"]); ?>]" value="<?php echo ($datafiled[$vo['emark']]); ?>"/>
            <input type="button" id="image_<?php echo ($vo["emark"]); ?>" value="选择图片" />
            <?php elseif(($vo["etype"] == 'addon') OR ($vo["etype"] == 'media')): ?>
            <script>
                $(function() {
                    var editorfile = KindEditor.editor({
                        allowFileManager : true,
                        uploadJson:'__APP__/Upload/uploadImg',
                        fileManagerJson :'__APP__/Upload/fileManagerJson'
                    });
                    KindEditor('#insertfile_<?php echo ($vo["emark"]); ?>').click(function() {
                        editorfile.loadPlugin('insertfile', function() {
                            editorfile.plugin.fileDialog({
                                fileUrl : KindEditor('#url_<?php echo ($vo["emark"]); ?>').val(),
                                clickFn : function(url, title) {
                                    KindEditor('#url_<?php echo ($vo["emark"]); ?>').val(url);
                                    editorfile.hideDialog();
                                }
                            });
                        });
                    });
                });
            </script>
            <input type="text" id="url_<?php echo ($vo["emark"]); ?>" name="filed[<?php echo ($vo["emark"]); ?>]" value="<?php echo ($datafiled[$vo['emark']]); ?>"/>
            <input type="button" id="insertfile_<?php echo ($vo["emark"]); ?>" value="选择文件" />
            <?php elseif($vo["etype"] == 'select'): ?>
            <select name="filed[<?php echo ($vo["emark"]); ?>]">
                <?php if(is_array($vo["opts"])): $k = 0; $__LIST__ = $vo["opts"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$opts): $mod = ($k % 2 );++$k; if($datafiled[$vo['emark']] == $opts): ?><option value="<?php echo ($opts); ?>" selected="selected"><?php echo ($opts); ?></option>
                        <?php else: ?>
                        <option value="<?php echo ($opts); ?>"><?php echo ($opts); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <?php elseif($vo["etype"] == 'radio'): ?>
            <?php if(is_array($vo["opts"])): $k = 0; $__LIST__ = $vo["opts"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$opts): $mod = ($k % 2 );++$k; if($datafiled[$vo['emark']] == $opts): ?><input name="filed[<?php echo ($vo["emark"]); ?>]" type="radio" value="<?php echo ($opts); ?>" checked="checked"/><?php echo ($opts); ?>
                    <?php else: ?>
                    <input name="filed[<?php echo ($vo["emark"]); ?>]" type="radio" value="<?php echo ($opts); ?>"/><?php echo ($opts); endif; endforeach; endif; else: echo "" ;endif; ?>
            <?php elseif($vo["etype"] == 'checkbox'): ?>
            <?php if(is_array($vo["opts"])): $k = 0; $__LIST__ = $vo["opts"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$opts): $mod = ($k % 2 );++$k; $arr = explode(',',$datafiled[$vo['emark']]); if(in_array($opts,$arr)){ echo '<input name="filedcheckbox['.$vo['emark'].'][]" type="checkbox" value="'.$opts.'" checked="checked"/>'.$opts; }else{ echo '<input name="filedcheckbox['.$vo['emark'].'][]" type="checkbox" value="'.$opts.'"/>'.$opts; } endforeach; endif; else: echo "" ;endif; ?>
            <?php elseif($vo["etype"] == 'stepselect'): ?>
            <input name="filed[<?php echo ($vo["emark"]); ?>]" value="<?php echo ($datafiled[$vo['emark']]); ?>" class="easyui-combotree combotree"
                   data-options="url:'__APP__/LinkPage/jsonTreeId?id=<?php echo ($vo["elink"]); ?>'" style="width:200px;"/><?php endif; ?>
        </td>
        </tr><?php endforeach; endif; ?>
    <script>
        $(function(){
            $.parser.parse($('.tempmodel'));
        })
    </script>
</tbody>
        </table>
    </div></div>

</form>
<script>
    $(function() {
        $('#sort_combotree').combotree({
            url:'__APP__/NewsSort/jsonTree',
            required:true,
            onChange:function(){
                var nid = $(this).combotree('getValue');
                //取得id之后，判断是否修改内容模型
                //ajax方法取得相关信息
                //var nid = node.id;
                /*
                $.messager.confirm('确认信息', '确认是否修改?', function(r){
                    if (r){
                        alert('confirmed:'+r);
                        location.href = 'http://www.google.com';
                    }
                });
                 */
                var href = '__APP__/News/tempmodel';
                $.ajax({
                    url:href,
                    type:'post',
                    data:{
                        id:nid
                    },
                    dataType:'html',
                    success:function(data){
                        //alert(data);
                        $('#conModel').html(data);
                    }
                });//ajax
            }
        });
        KindEditor.create('#content', {
            themeType : 'simple',
            allowFileManager : true,
            uploadJson:'__APP__/Upload/uploadImg',
            fileManagerJson :'__APP__/Upload/fileManagerJson',
            afterBlur : function() {
                this.sync();
            }
        });
        var editor = KindEditor.editor({
            allowFileManager : true,
            uploadJson:'__APP__/Upload/uploadImg',
            fileManagerJson :'__APP__/Upload/fileManagerJson'
        });
        KindEditor('#image1').click(function() {
            editor.loadPlugin('image', function() {
                editor.plugin.imageDialog({
                    imageUrl : KindEditor('#url1').val(),
                    clickFn : function(url, title, width, height, border, align) {
                        KindEditor('#url1').val(url);
                        editor.hideDialog();
                    }
                });
            });
        });

        /*
        var colorpicker;
        KindEditor('#colorpicker').bind('click', function(e) {
            e.stopPropagation();
            if (colorpicker) {
                colorpicker.remove();
                colorpicker = null;
                return;
            }
            var colorpickerPos = KindEditor('#colorpicker').pos();
            colorpicker = KindEditor.colorpicker({
                x : colorpickerPos.x,
                y : colorpickerPos.y + KindEditor('#colorpicker').height(),
                z : 19811214,
                selectedColor : 'default',
                noColor : '无颜色',
                click : function(color) {
                    KindEditor('#color').val(color);
                    colorpicker.remove();
                    colorpicker = null;
                }
            });
        });
        KindEditor.click(function() {
            if (colorpicker) {
                colorpicker.remove();
                colorpicker = null;
            }
        });

         */

    });
</script>