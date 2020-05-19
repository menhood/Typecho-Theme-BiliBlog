<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
    if($this->is('index')):
?>
    <div id="sidebar-l" class="sidebar-l">
        <div class="side_fixed w_l">
    <!--侧栏1-->
    <div class="row clearfix load-a" style="animation-delay: 0.2s;">
                        <div class="col-md-12 col-lg-12 column" >
                            <div class="userbox">
                                <div class="userbox-pic" style="background-image: url(&quot;<?php ($this->options->userboxpic()) ?>" alt="https://i.loli.net/2018/10/19/5bc945e7ef153.png"></div> <a class="userbox-name a" id="info-toggle"><?php $this->author();
                        ?></a>

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
                                <img src="<?php ($this->options->userboxhead()) ?>" class="userbox-head" alt="https://gravatar.loli.net/avatar/17842af77c9727c64e6468ad6d9d3f96" data-userinfo-popup-inited="true">
                            </div>
                        </div>
                    </div>
    <!--侧栏2-->
    <div class="row clearfix load-a" style="animation-delay: 0.4s;" id="ownerinfo">
                        <div class="col-xs-12 col-md-12 col-lg-12 column" style="padding:0">
                            <div class="card">
                                <p class="card-title">信息</p>
                                <div class="card-more"> <a href="<?php $this->options->siteUrl(); ?>index.php/about.html" class="a">更多></a></div>
                                <div class="card-content">
                                    <a href="<?php $this->options->siteUrl();
                                        ?>" class="a">
                                        <?php $this->options->title();
                                        ?>
                                    </a>
                                    <br>
                                    Theme <a href="https://github.com/menhood/Typecho-Theme-BiliBlog/" class="a">BiliBlog</a>
                                    <br>
                                    <?php _e('由 <a href="http://www.typecho.org" class="a">Typecho</a> 强力驱动');
                                    ?>
                                    <br>
                                    copyright
                                    <a href="<?php $this->options->adminUrl('login.php');
                                        ?>" class="a">&copy;</a> 2015-<?php echo date('Y');
                                    ?>
                                    <br>
                                    <a href="<?php $this->options->feedUrl();
                                        ?>" target="_blank" class="a">文章RSS</a> <!-- 文章的RSS地址连接 -->|
                                    <a href="<?php $this->options->commentsFeedUrl();
                                        ?>" target="_blank" class="a">评论RSS</a> <!-- 评论的RSS地址连接 -->
                                </div>
                            </div>
                        </div>
                    </div>
    <!--侧栏3-->
    <div class="row clearfix" style="display:none">
                        <div class="col-xs-12 col-md-12 col-lg-12 column" style="padding:0">
                            <div class="card">
                                <p class="card-title">标签</p>
                                <div class="card-more"> <a href="#modal-container-642507" role="button" data-toggle="modal" class="a">ooo</a>

                                </div>
                                <div class="card-content">
                                    <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags); ?>
                                    <ul class="tags-list">
                                        <?php while ($tags->next()) : ?>
                                            <li style="height:20px"><a style="color: rgb(<?php echo (rand(0, 255)); ?>, <?php echo (rand(0, 255)); ?>, <?php echo (rand(0, 255)); ?>)" href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'>#<?php $tags->name(); ?>#</a></li>
                                        <?php endwhile; ?>
                                        <div style="clear:both"></div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</div>    
<?php endif;?>
<?php if(!$this->is('index')):
?>
    <?php $this->widget('Widget_Metas_Category_List')->listCategories('wrapClass=nav-tab-bar'); ?>
<?php endif;?>