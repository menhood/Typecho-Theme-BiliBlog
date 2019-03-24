<?php
/**
 * BiliBlog 
 * 
 * @package biliblog
 * @author Menhood
 * @version 1.0.3
 * @link https://blog.menhood.wang/archives/BiliBlog.html
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;


 ?>

<?php  $this->need('header.php');?>


<!--主体-->
            <div class="main-body " style="margin-top:16px;" id="main-body">
                <div class="col-xs-12 col-md-12 col-lg-12 column">
                    
                    <!--侧栏-->
                    <div class="row clearfix">
                        <?php if ($this->options->lanshu==2 || $this->options->lanshu==3):?> 
                        <div class="col-md-3 column" style="padding:0" id="sidebar-l">
                            <!--侧栏1-->
                            <div class="row clearfix load-a" style="animation-delay: 0.2s;">
                                <div class="col-md-12 col-lg-12 column">
                                    <div class="userbox">
                                        <div class="userbox-pic" style="background-image: url(&quot;<?php  ($this->options->userboxpic()) ?>" alt="https://i.loli.net/2018/10/19/5bc945e7ef153.png"></div> <a class="userbox-name a" id="info-toggle">Menhood</a>

                                        <div class="userbox-bottom">
                                            <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
                                            <a class="postnum-a a" href="<?php $this->options->siteUrl(); ?>index.php/timeline.html">
                                                <p class="postnum-p" style="padding-top: 35px;">
                                                    <?php $stat->publishedPostsNum() ?>篇
                                                </p>
                                                <p class="postnum-p-text">文章</p>
                                            </a>
                                            <a class="comnum-a a" href="<?php $this->options->siteUrl(); ?>index.php/about.html#comments">
                                                <p class="comnum-p" style="padding-top: 35px;">
                                                <?php $stat->publishedCommentsNum() ?>条
                                                </p>
                                                <p class="comnum-p-text">评论</p>
                                            </a>
                                        </div>
                                        <img src="<?php  ($this->options->userboxhead()) ?>" class="userbox-head" alt="https://gravatar.loli.net/avatar/17842af77c9727c64e6468ad6d9d3f96" data-userinfo-popup-inited="true">
                                    </div>
                                </div>
                            </div>
                            <!--侧栏2-->
                            <div class="row clearfix load-a" style="animation-delay: 0.4s;" id="ownerinfo">
                                <div class="col-xs-12 col-md-12 col-lg-12 column">
                                    <div class="card">
                                        <p class="card-title">信息</p>
                                        <div class="card-more"> <a href="https://m.mdh.red" target="_blank" class="a">¡</a></div>
                                        <div class="card-content">
                                            <ul style="padding: 0;">
                                                <a href="<?php $this->options->bilibiliindex(); ?> " target="_blank">
                                                <li>
                                                    <img src="https://i.loli.net/2018/10/26/5bd270b485abb.png" style="width:auto;height:32px">
                                                    Bilibili Space
                                                </li>
                                                </a>
                                                <a href="<?php $this->options->musicindex(); ?>" target="_blank">
                                                <li>
                                                    <img src="https://i.loli.net/2018/10/30/5bd80a13e9b4f.png" style="width:auto;height:32px">
                                                    Netease Music
                                                </li>
                                                </a>
                                                <a href="https://www.menhood.wang" target="_blank">
                                                <li>
                                                    <img src="https://blog.menhood.wang/home.png" style="width:auto;height:32px">
                                                    Menhood Nav
                                                </li>
                                                </a>
                                                <a href="https://api.menhood.wang" target="_blank">
                                                <li>
                                                    <img src="https://i.loli.net/2018/10/30/5bd80b469ddac.png" style="width:auto;height:32px">
                                                   Menhood API
                                                </li>
                                                </a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--侧栏3-->
                            <!--侧栏4-->
                            <div class="row clearfix" style="display:none">
                                <div class="col-xs-12 col-md-12 col-lg-12 column">
                                    <div class="card">
                                        <p class="card-title">标签</p>
                                        <div class="card-more"> <a href="#modal-container-642507" role="button" data-toggle="modal" class="a">ooo</a>
                                        
                                        </div>
                                        <div class="card-content">
                                            <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags); ?>
                                            <ul class="tags-list">
                                            <?php while($tags->next()): ?>
                                            <li style="height:20px"><a style="color: rgb(<?php echo(rand(0, 255)); ?>, <?php echo(rand(0,255)); ?>, <?php echo(rand(0, 255)); ?>)" href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'>#<?php $tags->name(); ?>#</a></li>
                                            <?php endwhile; ?>
                                            <div  style="clear:both"></div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif;//判断单栏结束 ?>
                            <?php if ($this->options->lanshu==2):?>
                                <?php $this->need('sidebar.php'); ?>
                            <?php endif;?>
                        </div>
                        
                        <!--左侧栏TOC-->
                        		<?php if (!empty($this->options->sidebarBlock) && in_array('ShowTOC', $this->options->sidebarBlock) && !$this->is('index')): ?>
                        		<script>
                        			$('#smartFloat').style.top = $('#sidebar-l').height()+75;
                        		</script>
                                    <div class="" id="smartFloat" style="display:none;position: absolute;min-width: 240px;max-width: 262px;max-height: 500px;">
                                            <div class="card">
                                                <p class="card-title">目录&nbsp;<a href="javascript:void(0);" id="closetoc">关闭</a></p>
                                                <div class="card-more"> <input type="checkbox" checked="checked" class="al-toggle-button" id="toggle" />
                                                </div>
                                                <div class="card-content" id="post-category" style="overflow-y: scroll;max-height: 550px;"> </div>
                                            </div>
                                    </div>
                                <?php endif;?>   
                        <!--中间部分-->
                        <?php if ($this->options->lanshu==3):?>
                        <div class="col-md-6 column" id="pjax-container" style="width: 660px!important;">
                        <?php elseif ($this->options->lanshu==2):?>
                        <div class="col-md-9 column" id="pjax-container">
                        <?php elseif ($this->options->lanshu==1):?>
                        <div class="col-md-12 column" id="pjax-container">
                        <?php endif;?>    
                            <!--面包屑导航-->
                            <div class="row clearfix load-a">
                                <div class="col-xs-12 col-md-12 col-lg-12 column" style="margin-bottom: -20px;">
                                    <div class="breadcrumb">
                                        当前位置：<a href="<?php $this->options->siteUrl(); ?>" class="a">主页</a> &raquo;</li>
	                                    <?php if ($this->is('index')): ?><!-- 页面为首页时 -->
		                                最近文章
	                                    <?php elseif ($this->is('post')): ?><!-- 页面为文章单页时 -->
		                                <?php $this->category(); ?> &raquo; <?php $this->title() ?>
	                                    <?php else: ?><!-- 页面为其他页时 -->
		                                <?php $this->archiveTitle(' &raquo; ','',''); ?>
	                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!--文章主体-->
                            <div class="row clearfix ">
                                <div class="col-xs-12 col-md-12 col-lg-12 column">
                                    
                                    <article class="index-post">
                                        <?php $index=0; ?>
                                        <?php while($this->next()): ?>
                                        <?php $index++;?>
                                        <div class="post-card load-a" style="animation-delay: <?php echo 0.2*$index; ?>s;">
                                                <div class="userpost-head" style="background-image: url(<?php  ($this->options->userboxhead()) ?>);">
                                                </div>
                                                <i class="renzheng-a"></i>
                                                <div class="pc-r">
                                                <div class="authername">
                                                    <a href="<?php $this->author->permalink(); ?>" class="a"><?php $this->author(); ?></a>
                                                </div>
                                                <div class="posttime">
                                                    <?php $this->date('F j, Y'); ?>
                                                </div>
                                                <div class="tags">
                                                    #<?php $this->tags('# #', true, 'none'); ?>#
                                                </div>
                                                <div class="customtext">
                                                    <?php $this->fields->customtext();?>
                                                </div>
                                                <div class="abstract">
                                                    
                                                    <div class="types"><?php $this->category(','); ?></div>
                                                    <a href="<?php $this->permalink() ?>"><div class="thumb">
                                                        <div class="thumb-mask"></div>
                                                        <img src="<?php if($this->fields->thumb) {$this->fields->thumb();}else{echo 'https://i.loli.net/2019/03/24/5c978fcc8ced0.jpg';}?>" />
                                                    </div>
                                                    </a>
                                                    <div class="posttitle">
                                                        <a href="<?php $this->permalink() ?>" class="a"><?php $this->sticky();$this->title() ?></a>
                                                    </div>
                                                    <div class="abstracttext">
                                                        <?php $this->excerpt(30,'....'); ?>
                                                    </div>
                                                </div>
                                               <div class="btnbar">
                                                   <div class="comnum">
                                                       <span class="comnum-text-bar">
                                                           <a href="<?php $this->permalink() ?>#comments" class="a">
                                                           <i class="comment-ico"></i>
                                                           <span  class="text-offset"><?php $this->commentsNum('%d'); ?></span>
                                                           </a>
                                                        </span>
                                                   </div>
                                                   <?php if($this->likesNum): ?>
                                                   <div class="like">
                                                       <span class="like-text-bar" >
                                                           <a class="btn-like" data-cid="<?php $this->cid();?>" data-num="<?php $this->likesNum();?>">
                                                                <i  class="like-ico"></i>
                                                                <span class="post-likes-num">
                                                                <?php $this->likesNum();?>
                                                                </span>
                                                            </a>
                                                        </span>
                                                   </div>
                                                   <?php endif; ?>
                                               </div>
                                               </div>
                                        </div>
                                        <?php endwhile; ?>
                                        <?php $this->pageNav('上一页', '下一页', '2', '……'); ?>
                                    </article>
                                </div>
                            </div>
                        </div><!--pjax container end-->
                                <?php if ($this->options->lanshu==3):?>
                                <?php $this->need('sidebar.php'); ?>
                                <?php endif;?>
                            </div>
	

</div><!-- end #main-->

<?php $this->need('footer.php'); ?>
