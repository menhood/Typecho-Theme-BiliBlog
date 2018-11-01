<?php if (!defined( '__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if (!is_pjax()):?>
<?php $this->need('header.php'); ?>
<?php endif;?>
<!--中间部分-->
<!--<div class="col-md-6 column" id="pjax-container">-->
                        <script>
                            $(document).attr("title","<?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ''); ?>");
                        </script>
<!--面包屑导航-->
<div class="row clearfix">
    <div class="col-md-12 column" style="margin-bottom: -32px;margin-top: 8px;">
        <div class="breadcrumb">当前位置：<a href="<?php $this->options->siteUrl(); ?>" class="a">主页</a> &raquo;</li>
            <?php if ($this->is('index')): ?>
            <!-- 页面为首页时 -->Latest Post
            <?php elseif ($this->is('post')): ?>
            <!-- 页面为文章单页时 -->
            <?php $this->category(); ?> &raquo;
            <?php $this->title() ?>
            <?php else: ?>
            <!-- 页面为其他页时 -->
            <?php $this->archiveTitle(' &raquo; ','',''); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--文章主体-->
<div class="row clearfix" >
    <div class="col-md-12 column">
        <article class="post" style="background-color:#fff;border-radius:8px;padding: 8px;margin-top: 20px;">
             <h3 class="archive-title"><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ''); ?></h3>

            <?php if ($this->have()): ?>
            <?php while($this->next()): ?>
            <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
                	<h2 class="post-title" itemprop="name headline"><a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>

                <ul class="post-meta">
                    <li itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <?php _e( '作者: '); ?>
                        <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author">
                            <?php $this->author(); ?></a>
                    </li>
                    <li>
                        <?php _e( '时间: '); ?>
                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished">
                            <?php $this->date(); ?></time>
                    </li>
                    <li>
                        <?php _e( '分类: '); ?>
                        <?php $this->category(','); ?></li>
                    <li itemprop="interactionCount">
                        <a href="<?php $this->permalink() ?>#comments">
                            <?php $this->commentsNum('评论', '1 条评论', '%d 条评论'); ?></a>
                    </li>
                </ul>
                <div class="post-content" itemprop="articleBody">
                    <?php $this->content('- 阅读剩余部分 -'); ?></div>
            </article>
            <?php endwhile; ?>
            <?php else: ?>
            <article class="post">
                 <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>

            </article>
            <?php endif; ?>
            <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?></article>
    </div>
</div>
</div>
<!--</div> end #main-->
<?php if (!is_pjax()):?>
<?php $this->need('footer.php'); ?>
<?php endif;?>