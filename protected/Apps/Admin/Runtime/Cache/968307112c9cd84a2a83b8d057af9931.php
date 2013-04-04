<?php if (!defined('THINK_PATH')) exit();?>
    <div class="easyui-layout layout_setting_settinglist">
        <div data-options="region:'west',split:true" title="参数分类" style="width:150px;">
            <ul class="easyui-tree tree_setting_settinglist" data-options="url:'__APP__/Setting/jsonTree'" style="padding: 10px 5px;">
                <!--
                <?php if(is_array($list)): foreach($list as $key=>$sort): ?><tr><a href="javascript:viod(0);" cmshref="__APP__/Setting/settinglist?id=<?php echo ($sort["id"]); ?>"><?php echo ($sort["text"]); ?></a></tr><?php endforeach; endif; ?>
                -->
            </ul>
        </div>
        <div data-options="region:'center'" style="">
            <div id="tabs_setting_settinglist" class="easyui-tabs"  fit="true" border="false"  >

            </div>



            <script>
                $(function(){
                    var height = $('.indexcenter').height();
                    var classId = 'setting_settinglist';
                    $('.layout_'+classId).css('height',height-50);
                    $('.tree_'+classId).tree({
                        onClick:function(){
                            var node = $('.tree_'+classId).tree('getSelected');
                            var nid = node.id;
                            //var clickclass = $('.tree_'+classId+' .tree-node-selected a');
                            var url = '__APP__/Setting/settinglist?id='+nid;
                            //var classId = 'modelsortlist';
                            var subtitle = node.text;
                            if(!$('#tabs_'+classId).tabs('exists',subtitle)){
                                $('#tabs_'+classId).tabs('add',{
                                    title:subtitle,
                                    content:subtitle,
                                    closable:true,
                                    href:url,
                                    tools:[{
                                            iconCls:'icon-mini-refresh',
                                            handler:function(){
                                                updateTab(classId,url,subtitle);
                                            }
                                        }]
                                });
                                return false;
                            }else{
                                $('#tabs_'+classId).tabs('select',subtitle);
                                return false;
                            }

                        }//onclick
                    });
                })
            </script>



        </div>