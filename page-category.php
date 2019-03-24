<?php
/**
* Template Page of Categorys Archives
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
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
                                <div class="<?php if (!is_pjax()):?>
                                            col-md-8 column col-md-offset-1
                                            <?php else:?>
                                            col-md-12 column
                                            <?php endif;?>" style="margin-bottom: -32px;">
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
                                <div class="<?php if (!is_pjax()):?>
                                            col-md-8 column col-md-offset-1
                                            <?php else:?>
                                            col-md-12 column
                                            <?php endif;?>">
                                    <article class="post" style="background-color:#fff;border-radius:8px;margin-top: 20px;">
	<?php $this->widget('Widget_Metas_Category_List')->to($categorys);?>
    <?php if ($categorys->have()): ?>
        <?php while($categorys->next()): ?>
            <div class="categorys-item">
                <div class="categorys-title">
                    <a href="<?php $categorys->permalink();?>"><?php $categorys->name();?></a><span> ：<?php $categorys->count();?></span>
                </div>
                <?php $catlist =$this->widget('Widget_Archive@categorys_'.$categorys->mid, 'pageSize=10000&type=category', 'mid='.$categorys->mid); ?>
                <?php if($catlist->have()): ?>
            		<div class="post-lists">
						<div class="post-lists-body">
						<?php while($catlist->next()): ?>
							<div class="post-list-item">
								<div class="post-list-item-container">
									<div class="item-label">
										<div class="item-title"><a href="<?php $catlist->permalink() ?>"><?php $catlist->title() ?></a></div>
										<div class="item-meta clearfix">
											<div class="item-meta-date"> <?php $catlist->date('M j, Y'); ?> </div>
										</div>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
						</div>
					</div>
            	<?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</article>
                                        <?php $this->need('comments.php'); ?>
                                        <ul class="post-near">
                                        <li>上一篇: <?php $this->thePrev('%s','没啦'); ?></li>
                                        <li>下一篇: <?php $this->theNext('%s','没啦'); ?></li>
                                        </ul>    
                                </div>
                            </div>
                        </div>


<!--</div> end #main-->

<?php if (!is_pjax()):?>
<?php $this->need('footer.php'); ?>
<?php endif;?>