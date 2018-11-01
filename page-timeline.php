<?php
/**
* Template Page of Timeline Archives
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
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
                                    <article class="post" style="background-color:#fff;border-radius:8px;margin-top: 20px;">
                                                <?php
    $stat = Typecho_Widget::widget('Widget_Stat');
    $this->widget('Widget_Contents_Post_Recent', 'pageSize='.$stat->publishedPostsNum)->to($archives);
    $year=0; $mon=0; $i=0; $j=0;
    $output = '<div class="categorys-item">';
    while($archives->next()){
        $year_tmp = date('Y',$archives->created);
        $mon_tmp = date('m',$archives->created);
        $y=$year; $m=$mon;
        if ($year > $year_tmp || $mon > $mon_tmp) {
            $output .= '</div></div>';
        }
        if ($year != $year_tmp || $mon != $mon_tmp) {
			 $year = $year_tmp;
			 $mon = $mon_tmp;
			 $output .= '<div class="categorys-title">'.date('M Y',$archives->created).'</div><div class="post-lists"><div class="post-lists-body">';
        }
        $output .= '<div class="post-list-item"><div class="post-list-item-container"><div class="item-label"><div class="item-title"><a href="'.$archives->permalink .'">'. $archives->title .'</a></div><div class="item-meta clearfix"><div class="item-meta-date"> '.date('M j, Y',$archives->created).' </div></div></div></div></div>';
    }
    $output .= '</div></div></div>';
    echo $output;
    ?>
                                            
                                    </article>
                                        <?php $this->need('comments.php'); ?>   
                                </div>
                            </div>
                        </div>

<!--</div> end #main-->

<?php if (!is_pjax()):?>
<?php $this->need('footer.php'); ?>
<?php endif;?>