<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if ($this->is('index')||$this->is('archive') ):
?>
<!--右侧栏-->

<div id="sidebar-r" class="sidebar-r">
    <div class="side_fixed w_r">
        <!--右侧栏1-->
        <div class="card load-a" style="animation-delay:0.2s;margin-top:0;" id="Post_Recent">
            <p class="card-title">
                最近文章
            </p>
            <div class="card-more">
                <a href="<?php $this->options->siteUrl();
                    ?>index.php/timeline.html" target="_blank" class="card-more-a a">。。。</a>
            </div>
            <div class="card-content">
                <?php $this->widget('Widget_Contents_Post_Recent')->to($post);
                ?>
                <?php while ($post->next()): ?>
                <a href="<?php $post->permalink();
                    ?>" title="<?php $post->title();
                    ?>" class="a">
                    <li><?php $post->title(25, '…');
                        ?></li>
                </a>
                <?php endwhile;
                ?>
            </div>
        </div>
        <!--右侧栏2-->
        <div class="card load-a" style="animation-delay:0.4s" id="Comments_Recent">
            <p class="card-title">
                最近评论
            </p>
            <div class="card-more">
                <a href="<?php $this->options->siteUrl();
                    ?>index.php/about.html" target="_blank" class="card-more-a a">...</a>

            </div>
            <div class="card-content Comments_Recent" id="zjpl">
                <?php $this->widget('Widget_Comments_Recent','ignoreAuthor=true')->parse('<a href="{permalink}" class="a"><li style="max-width: 280px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{text}</li></a>');
                ?>

            </div>
        </div>
    </div>
</div>
<!-- end right_sidebar -->
<?php endif;
?>


<?php if($this->is('post') ||  $this->is('page')):
      if($this->is('page','timeline') || $this->is('page','links')){
        $style = 'style="margin-left: 0;background:#fff;"';  
      }
?>
<div class="up-info-holder" <?php  echo $style ;?> >
    <div class="fixed-box" >
        <div class="up-info-block">
            <a class="up-face-holder " href="<?php $this->author->permalink();
                ?>" target="_blank">
                <img class="up-face-image" src="<?php ($this->options->userboxhead()) ?>">
                <i class="up-verify-icon-s" title="已认证"></i>
            </a>
            <div class="up-info-right-block">
                <div class="row-1">
                    <a class="up-name b-vip-red" href="<?php $this->author->permalink();
                        ?>" target="_blank"><?php $this->author();
                        ?></a>
                    <span class="level l6"></span>
                    <div class="nameplate-holder">
                        <i class="nameplate"></i>
                    </div>
                </div>
                <div class="row-2">
                    点赞:
                    <span class="zans-num"><?php get_author_Allzans($this->authorId);
                        ?></span>
                    <span class="view">阅读:</span>
                    <span class="view-num"><?php get_author_AllViews($this->authorId);
                        ?></span>
                </div>
            </div>
        </div>

<?php if( !$this->is('page')):
?>
        <div class="rightside-article-list-btn">
            <span class="icon-list"></span>
            <span class="label">查看目录</span>
            <span class="title" title="<?php $this->title() ?>"><?php $this->title() ?></span>
        </div>
<?php endif;
?>
        <div class="up-article-list-block">
            <div class="block-title">
                推荐文章
            </div>
            <ul class="article-list">
                <?php getRandomPosts('3');
                ?>
                <a class="more-article" href="<?php $this->options->siteUrl(); ?>index.php/timeline.html" target="_blank">查看更多</a>
            </ul>
        </div>
    </div>
</div>

<div class="right-side-bar">
    <div class="to-comment">
        <div class="comment-num-holder">
            <span class="comment-num"><?php $this->commentsNum('%d');
                ?></span>
        </div>
    </div>
    <div class="to-top"></div>
</div>

<div id="article-list-index" class="show top ">
    <div class="title-holder">
        <span class="title">目录</span><span class="icon-close" id="closetoc"></span>
    </div>
    <div class="article-list-title">
        <?php $this->title() ?>
    </div>
    <div class="index-holder" id="post-category">
        
    </div>
</div>
<?php endif;
?>
