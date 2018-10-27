<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <link id="tabico" rel="icon" href="<?php $this->options->favicon(); ?>" />
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>

    <!-- 使用url函数转换相关路径 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('biliblog.css'); ?>">
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.loli.net/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
        <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet">
        <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
        

    <!--[if lt IE 9]>
    <script src="//cdnjscn.b0.upaiyun.com/libs/html5shiv/r29/html5.min.js"></script>
    <script src="//cdnjscn.b0.upaiyun.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
</head>
<body id="body">
<!--[if lt IE 8]>
    <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.</div>
<![endif]-->

<div class="container">
    <?php if (!is_pjax()):?>
            <!--导航-->
            <div class="row clearfix">
                <div class="col-md-12 column" style="padding: 0;margin: 0;height: 50px;">
                    <nav class="navbar " role="navigation" style="height: 50px;background-color:#fff;">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1"> 
					 <span class="sr-only">Toggle navigation</span>
					 <span class="icon-bar"></span>
					 <span class="icon-bar"></span>
					 <span class="icon-bar"></span>
					 </button> 
					 <div class="logo">
                        <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                            <?php $this->options->title(); ?>
                            <?php if ($this->options->logoUrl): ?>
                            <img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" />
                        </a>
                        <?php endif; ?>
                        </div>
				</div>
				
				<div class="collapse navbar-collapse" id="navbar-collapse-1">
					<ul class="nav navbar-nav">
                    <?php $this->widget('Widget_Contents_Page_List')->parse('<li class="nav-li"><a data-pjax href="{permalink}">{title}</a></li>'); ?>
					</ul>

				</div>
				
			
            <div class="search"> <a id="modal-642507" href="#modal-container-642507" role="button" data-toggle="modal" class="search-a">搜索</a>
			
			<div class="modal fade" id="modal-container-642507" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title" id="myModalLabel">
							搜索	
							</h4>
						</div>
						<div class="modal-body">
							<form id="search"  method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                                    <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
                                    <input type="text" id="s" name="s" class="form-control" placeholder="<?php _e('输入关键字搜索'); ?>" />
                            </form>
                            <!--标签云-->
                            <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags); ?>
                            <ul class="tags-list">
                            <?php while($tags->next()): ?>
                            <li><a style="color: rgb(<?php echo(rand(0, 255)); ?>, <?php echo(rand(0,255)); ?>, <?php echo(rand(0, 255)); ?>)" href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'>#<?php $tags->name(); ?>#</a></li>
                            <?php endwhile; ?>
                            </ul>
						</div>
						<div class="modal-footer" style="border-top: 0px solid #e5e5e5; "> 
							 <button type="button" class="btn btn-primary" onclick="ssub()">搜索</button>
							 <script>function ssub(){document.getElementById("search").submit();}</script>
						</div>
					</div>
				</div>
			</div>
                            <!---->
                        </div>
                    </nav>
                </div>
            </div>
            <!--导航结束-->
            <?php endif;?>