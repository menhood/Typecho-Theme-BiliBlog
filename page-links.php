<?php
/**
* Template Page of Links 
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php if (!is_pjax()):?>
<?php $this->need('header.php'); ?>
<?php endif;?>
<?php $linksarray=array(
    "Menhood"=>array(
        "name"=>"Menhood",
        "img"=>"https://gravatar.loli.net/avatar/17842af77c9727c64e6468ad6d9d3f96",
        "url"=>"https://blog.menhood.wang/",
        "desc"=>"援军的日常记录"
        ),
    "Darker"=>array(
        "name"=>"Darker",
        "img"=>"https://i.loli.net/2018/10/25/5bd132e394da0.png",
        "url"=>"https://darker.me/",
        "desc"=>"在线弹幕库 可加载本地视频"
        )    
    );
?>
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
                                        当前位置：<a href="<?php $this->options->siteUrl(); ?>" class="a">Home</a> &raquo;</li>
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
                                        <?php foreach($linksarray as $v){
echo <<<EOF
			                        <div class="row clearfix" style="margin-top:20px">
				                        <div class="col-md-2 column">
				                            <img class="links-head" src=" {$v['img']}" />
				                        </div>
				                        <div class="col-md-6 column" >
				                            <p class="links-title">{$v['name']}</p>
                                            <span class="links-dedsc">{$v['desc']}</span>
				                        </div>
				                        <div class="col-md-4 column">
				                            <div class="links-go" onclick="window.open('{$v['url']}')">
                                                    <span class="links-go-text">访问</span>
                                            </div>
				                        </div>
			                        </div>
EOF;
} ?>
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