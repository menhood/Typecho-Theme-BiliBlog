<?php if (!defined( '__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<!--中间部分-->
                        <script>
                            $(document).attr("title","<?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ''); ?>");
        //  $("body").attr("style", "background:#fff");
                        </script>

<!--文章主体-->
<div class="container">

    
    <div class="main-body">
        <?php $this->need('sidebar-l.php');
    ?>
        <article class="mid-body">
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
                 <h2 class="post-title"><?php _e('啥也没有'); ?></h2>
                <div class="none-content"></div>
            </article>
            <?php endif; ?>
            <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?></article>
    </article>
    
        <?php $this->need('sidebar-r.php');
    ?>
</div>
</div>

    
<?php $this->need('footer.php'); ?>