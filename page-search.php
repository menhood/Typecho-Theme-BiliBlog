<?php
/**
* Template Page of Search
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<?php if (!is_pjax()):?>
<?php $this->need('header.php'); ?>
<?php endif;?>

	<div class="row clearfix">
		<div class="col-xs-12 col-md-12 col-lg-12  column">
		    
		</div>
	</div>

<!--中间部分-->
                        
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
                                            <?php endif;?>" >
                                    <article class="post" style="background-color:#fff;border-radius:8px;padding: 20px;margin-top: 20px;;margin-bottom: 8px;">
                                               <h2 style="text-align: center;color:#00a1d6">搜索</h2>
				<form class="bs-example bs-example-form" id="search"  method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
		        <div class="row">
			        <div class="col-xs-12 col-md-12 col-lg-12">
				        <div class="input-group">
				            <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
					        <input type="text" id="s" name="s" class="form-control" placeholder="<?php _e('输入关键字搜索'); ?>" />
					        <span class="input-group-btn">
                            <button type="button" class="search-btn" onclick="ssub()">搜索</button>
                            <script>function ssub(){document.getElementById("search").submit();}</script>
                            </span>
				                    </div><!-- /input-group -->
			                    
	                        </form>
				            <!--标签云-->
                            <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags); ?>
                            <ul class="tags-list">
                            <?php while($tags->next()): ?>
                            <li><a style="color: rgb(<?php echo(rand(0, 255)); ?>, <?php echo(rand(0,255)); ?>, <?php echo(rand(0, 255)); ?>)" href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'>#<?php $tags->name(); ?>#</a></li>
                            <?php endwhile; ?>
                            </ul>       
                            </div><!-- /.col-lg-6 -->
		                    </div><!-- /.row -->
                            </article> 
                        </div>
                    </div>
<!--</div> end #main-->
<?php if (!is_pjax()):?>
<?php $this->need('footer.php'); ?>
<?php endif;?>