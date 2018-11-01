<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if (!is_pjax()):?>
<?php $this->need('header.php'); ?>
<?php endif;?>
<!--中间部分-->
                        <!--<div class="col-md-6 column" id="pjax-container">-->
                        <script>
                            $(document).attr("title","<?php $this->title()?>");
                            $('#post-category').html("<!-- index-menu -->");
                        </script>                        
                            <!--面包屑导航-->
                            <div class="row clearfix">
                                <div class="col-md-12 column" style="margin-bottom: -32px;margin-top: 8px;">
                                    <div class="breadcrumb">
                                        当前位置：<a href="<?php $this->options->siteUrl(); ?>" class="a">主页</a> &raquo;</li>
	                                    <?php if ($this->is('index')): ?><!-- 页面为首页时 -->
		                                Latest Post
	                                    <?php elseif ($this->is('post')): ?><!-- 页面为文章单页时 -->
		                                <?php $this->category(); ?> &raquo; <?php $this->title() ?>
	                                    <?php else: ?><!-- 页面为其他页时 -->
		                                <?php $this->archiveTitle(' &raquo; ','',''); ?>
	                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!--文章主体-->
                            <div class="row clearfix" >
                                <div class="col-md-12 column" >
                                    <article class="post" style="background-color:#fff;border-radius:8px;padding: 8px;margin-top: 20px;">
                                                <div class="post-head blur" style="background-image: url(<?php $this->fields->thumb(); ?>);width:100%;height:auto;">
                                                </div>
                                                <h1 class="post-title" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
                                              <ul class="post-meta">
                                                <li itemprop="author" itemscope itemtype="http://schema.org/Person"><?php _e('作者: '); ?>
                                                <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a>
                                                </li>
                                                <li><?php _e('时间: '); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
                                                </li>
                                                <li><?php _e('分类: '); ?><?php $this->category(','); ?>
                                                </li>
                                              </ul>
                                              <div class="post-content" itemprop="articleBody">
                                                <?php $this->content(); ?>
                                              </div>
                                            
                                    </article>
                                        <?php $this->need('comments.php'); ?>   
                                </div>
                            </div>
                        </div>
<!--</div> end #main-->
<?php if (!is_pjax()):?>
<?php $this->need('footer.php'); ?>
<?php endif;?>