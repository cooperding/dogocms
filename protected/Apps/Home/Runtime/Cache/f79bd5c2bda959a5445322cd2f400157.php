<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo ($title); ?>-站长管理</title>
        <meta name="keywords" content="<?php echo ($keywords); ?>" />
        <meta name="description" content="<?php echo ($description); ?>" />
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/Skin/default/style/comm.css">
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/Skin/default/style/css.css">
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/Skin/default/style/slide.css">
        <script type="text/javascript" src="__PUBLIC__/Style/Js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="__PUBLIC__/Style/Js/jQuery.blockUI.js"></script>
        <script type="text/javascript" src="__PUBLIC__/Style/Js/jquery.SuperSlide.js"></script>
    </head>
    <body>
        <div class="top wpall">
            <div class="box wp">
                <div class="top_l f_left">
                    <span class="L_passport">&nbsp;您好,欢迎来到admin管理先生网<a href="/index.php/member_login">请登录</a><a href="<?php echo U('Passport/add');?>">免费注册</a><a href="/index.php/member_login/forgetpwd">忘记密码</a></span></div>
                <div class="top_r f_right">

                </div><!--top_r-->
                <div class="clear"></div>
            </div><!--box-->
        </div>
        <div class="box wpall">
            <div class="head">
                <div class="box wp">
                    <div class="logo f_left">
                        <h1><a href="http://www.adminsir.net/"><img src="__PUBLIC__/Skin/default/images/logo.jpg" alt=""></a></h1>
                    </div><!--mall_logo-->
                    <div class="search f_right">
                        <div class="box">
                            <div class="usual">
                                <div class="search_con">
                                    <form action="__APP__/Search" method="get" target="_blank">
                                        <input type="text" class="sinput" name="words">
                                        <input type="submit" value=" " class="search_sub">
                                    </form>
                                </div><!--search_con-->
                            </div></div><!--box-->

                    </div><!--mall_search-->
                    <div class="clear"></div>
                </div><!--box-->
            </div><!--head-->
        </div>
        <!--box-->

        <div class="box menu wpall">
            <div class="nav wp">
                <ul>
                    <?php Load("extend"); $_result=list_to_tree(M('NavHead')->order("id asc")->limit(0,50)->select(),"id", "parent_id", "children"); if ($_result): $i=0;foreach($_result as $key=>$nav):++$i;$mod = ($i % 2 );?><li><a href="__APP__/<?php echo ($nav["url"]); ?>" target="_self"><?php echo ($nav["text"]); ?></a></li><?php endforeach; endif;?>
                    <div class="clear"></div>
                </ul>
            </div><!--nav-->
        </div>
<div class="blank"></div>
<div class="box wp">
    <div class="place placebd">
        <h3>当前位置：<a href="/">首页</a>&gt;&gt;</h3>
    </div><!--place-->
</div><!--box-->
<div class="blank"></div>
<div class="block wp">
    <div class="blockL f_right">
<div class="box">
    <div class="flash">
        <!-- content S -->
        <div class="effect">
            <div id="slideBox" class="slideBox">
                <div class="hd">
                    <ul><li>1</li><li>2</li></ul>
                </div>
                <div class="bd">
                    <ul>
                        <?php $_result=M('Flash')->order("id desc")->limit(0,6)->where(" (`status`='true') ")->select(); if ($_result): $i=0;foreach($_result as $key=>$flash):++$i;$mod = ($i % 2 );?><li><a href="<?php echo ($flash["eurl"]); ?>"><img src="<?php echo ($flash["epic"]); ?>" title="<?php echo ($flash["emark"]); ?>" /></a></li><?php endforeach; endif;?>
                    </ul>
                </div>
            </div>

        </div>
        <!-- content E -->
    </div><!--flash-->
</div><!--box-->

<div class="blank"></div>
<div class="box">
    <div class="common commonbd">
        <div class="common_top commontopbd">
            <div class="ctop_l f_left">专栏推荐</div>
            <div class="ctop_m f_left"></div>
            <div class="ctop_r f_right"></div>
            <div class="clear"></div>
        </div><!--common_top-->
        <div class="common_cont phototext">
            <ul>
                <?php $_result=M('Title')->table('ding_title t')->join(' ding_news_sort ns on ns.id=t.sort_id ')->field( 't.*,ns.text as sortname' )->order("id desc")->where(" (t.status='true') and (t.is_recycle='false') ")->limit(0,2)->select(); if ($_result): $i=0;foreach($_result as $key=>$article):++$i;$mod = ($i % 2 );?><li>
                        <div class="phototext_pic f_left">
                            <a href="__APP__/Content/?id=<?php echo ($article["id"]); ?>"><img alt="<?php echo ($article["title"]); ?>" src="<?php echo ($article["titlepic"]); ?>"></a>
                        </div><!--phototext_pic-->
                        <div class="phototext_text f_right">
                            <h3><a href="__APP__/Content/?id=<?php echo ($article["id"]); ?>"><?php echo ($article["title"]); ?></a></h3>
                            <p><?php echo ($article["description"]); ?></p>
                        </div><!--phototext_text-->
                        <div class="clear"></div>
                    </li><?php endforeach; endif;?>
            </ul>
        </div><!--common_cont-->
        <div class="common_cont text">
            <ul>
                <?php $_result=M('Title')->table('ding_title t')->join(' ding_news_sort ns on ns.id=t.sort_id ')->field( 't.*,ns.text as sortname' )->order("id desc")->where(" (t.status='true') and (t.is_recycle='false') ")->limit(0,10)->select(); if ($_result): $i=0;foreach($_result as $key=>$article):++$i;$mod = ($i % 2 );?><li><a href="__APP__/Content/?id=<?php echo ($article["id"]); ?>" title="<?php echo ($article["title"]); ?>" target="_blank"><?php echo ($article["title"]); ?></a></li><?php endforeach; endif;?>
            </ul>
        </div><!--common_cont-->
    </div><!--common-->
</div><!--box-->

    </div><!--blockL-->

    <div class="blockLA f_left">
        <div class="box">
            <div class="common listbd list">
                <div class="common_top commontopbd">
                    <div class="ctop_l f_left"><span><?php echo ($words); ?></span>搜索结果</div>
                    <div class="ctop_m f_left"></div>
                    <div class="ctop_r f_right"><a href="#"></a></div>
                    <div class="clear"></div>
                </div><!--common_top-->
                <div class="common_cont listnews">
                <?php if(is_array($dogocms)): foreach($dogocms as $key=>$dogocms): ?><dl>
                        <dt>
                        <a href="__APP__/Content/?id=<?php echo ($dogocms["id"]); ?>"><?php echo ($dogocms["title"]); ?></a>
                        </dt>
                        <dd><?php echo ($dogocms["dwend1"]); ?></dd>
                        <dd>分类: <a href="__APP__/List/?id=<?php echo ($dogocms["sort_id"]); ?>"><?php echo ($dogocms["sortname"]); ?></a>   [<?php echo (date("Y-m-d H:i:s",$dogocms["addtime"])); ?>]</dd>
                    </dl><?php endforeach; endif; ?>

                    <div class="pagelist"><?php echo ($page); ?></div><!--pagelist-->
                </div><!--common_cont-->
            </div><!--common-->

        </div><!--box-->
    </div><!--blockFL-->
    <div class="clear"></div>
</div><!--block-->






<div class="blank"></div>
<div class="foot wp">
<p>© （<a href="http://www.adminsir.net">www.adminsir.net</a>）站长先生网--版权所有，并保留所有权利。<br />
Powered by <a href="http://www.dingcms.com" target="_blank">www.dingcms.com</a><a href="http://webscan.360.cn/index/checkwebsite/url/www.adminsir.net"></a></p>
</div>
<script type="text/javascript">jQuery(".slideBox").slide( { mainCell:".bd ul",effect:"leftLoop",autoPlay:true} );</script>
</body>
</html>