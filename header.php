<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta name="Description" content="<?php ($this->options->Description()) ?>">
    <meta name="Keywords" content="<?php ($this->options->Keywords()) ?>">
    <meta charset="<?php $this->options->charset();
    ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <link id="tabico" rel="icon" href="<?php $this->options->favicon();
    ?>" />
    <title><?php $this->archiveTitle(array(
        'category' => _t('分类 %s 下的文章'),
        'search' => _t('包含关键字 %s 的文章'),
        'tag' => _t('标签 %s 下的文章'),
        'author' => _t('%s 发布的文章')
    ), '', ' - ');
        ?><?php $this->options->title();
        ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('static/css/biliblog.css');
    ?>">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link href="https://cdnjs.loli.net/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.css" rel="stylesheet">
    <script src="https://cdnjs.loli.net/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.loli.net/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.loli.net/ajax/libs/dplayer/1.22.2/DPlayer.min.js"></script>
    <link href="https://cdnjs.loli.net/ajax/libs/nprogress/0.2.0/nprogress.css" rel="stylesheet">
    <script src="https://cdnjs.loli.net/ajax/libs/nprogress/0.2.0/nprogress.js"></script>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('static/css/prism.css');
    ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('static/css/jquery.jgrowl.min.css');
    ?>">
    <script src="<?php $this->options->themeUrl('static/js/jquery.jgrowl.min.js');
        ?>"></script>
    <script src="<?php $this->options->themeUrl('static/js/scrollgress.js');
        ?>"></script>
    <script src="<?php $this->options->themeUrl('static/js/md5.min.js');
        ?>"></script>

    <!--[if lt IE 9]>
        <script src="//cdnjscn.b0.upaiyun.com/libs/html5shiv/r29/html5.min.js"></script>
        <script src="//cdnjscn.b0.upaiyun.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header();
    ?>
    <meta name="baidu-site-verification" content="WIk8Uorihz" />
    <script>
        //php向js写入变量
        var hasLogin = "<?= $this->user->hasLogin();
        ?>";
    </script>

</head>
<div id="widtherror"><a href="#" rel="nofollow">|ω・) 屏幕太小，放不下内容</a></div>
<body id="body">
    <div id="closetoc_msk" style="position: fixed;width: calc(100% - 400px);z-index: 1;height: 100%;display:none;"></div>
    <div class="login-box-msk" id="login-box-msk"></div>
    <!--[if lt IE 8]>
        <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>');
    ?>.</div>
    <![endif]-->

    <?php if ($this->is('index')): ?>    <!--<div class="container">-->
        <?php endif;
        //判断主页结束 ?>
        <!--导航-->
        <div class="nav-mask">
            <div class="navTmp">
                <li class="nav-li">
                    <a href="<?php $this->options->siteUrl();
                        ?>">首页</a>
                </li>
                <?php $this->widget('Widget_Contents_Page_List')->parse('<li class="nav-li"><a  href="{permalink}">{title}</a></li>');
                ?>
            </div>
            <div class="scrollgress"></div>
        </div>
        <nav class="nav">
            <div class="logo">
                <a id="logo" href="<?php $this->options->siteUrl();
                    ?>">
                    <?php $this->options->title();
                    ?>

                </a>
                <?php if ($this->options->logoUrl) : ?>
                <a href="javascript:location.reload();">
                    <img src="<?php $this->options->logoUrl() ?>" alt="宽屏" title="点击进入宽屏模式（仅支持非首页页面）" />
                </a>
                <?php endif;
                ?>
            </div>

            <ul class="nav navbar-nav">
                <?php $this->widget('Widget_Contents_Page_List')->parse('<li class="nav-li"><a href="{permalink}">{title}</a></li>');
                ?>
            </ul>


            <div class="login" id="login-btn">
                <a id="login-a" href="javascript:void(0)" class="login-a"><img id="login-img" class="login-img" src="
                    <?php
                    if ($this->user->hasLogin()) { $this->options->userboxhead();
                    }
                    ?>" /></a>
                <script>
                    <?php
                    if (!$this->user->hasLogin() && $this->options->commentsRequireMail) {
                        echo "$(function() {var __url=\"\",__mail =\"";
                        $this->remember('mail');
                        echo '";if(__mail!==""){ __url ="https://cdn.v2ex.com/gravatar/"+md5(__mail);}else{ __url="'.$this->options->rootUrl.'/usr/themes/biliblog/static/img/akari.jpg";}$("#login-img").attr("src",__url);})';
                    }
                    ?>
                </script>
                <div class="login-box" id="login-box"  <?php if ($this->user->hasLogin()){echo 'style="border:0px solid;"';} ?>>
                    <?php if ($this->user->hasLogin()): ?>
                    <ul class="s-menu music-show">
                        <li><a href="<?php $this->options->adminUrl('login.php');?>" target="_blank"><i class="b-icon b-icon-back"></i><em>后台首页</em><i class="new"></i></a></li>
                        <li><a href="<?php $this->options->adminUrl('manage-posts.php');?>" target="_blank"><i class="b-icon b-icon-mpost"></i><em>编辑文章</em></a></li>
                        <li><a href="<?php $this->options->adminUrl('manage-pages.php');?>" target="_blank"><i class="b-icon b-icon-mpage"></i><em>编辑页面</em></a></li>
                        <li><a href="<?php $this->options->adminUrl('manage-comments.php');?>" target="_blank"><i class="b-icon b-icon-comment"></i><em>管理评论</em></a></li>
                        <li><a href="<?php $this->options->adminUrl('options-general.php');?>" target="_blank"><i class="b-icon b-icon-basesetting"></i><em>基本设置</em></a></li>
                    </ul>
                    <!--<div class="btn-panel" style="flex-wrap:wrap">-->
                    <!--    <a class="login-box-btn" href="<?php //$this->options->profileUrl();/ ?>">当前用户：<?php //$this->user->screenName();/ ?></a>-->
                    <!--    <a class="login-box-btn" href="<?php //$this->options->adminUrl();/ ?>manage-posts.php">文章</a>-->
                    <!--    <a class="login-box-btn" href="<?php //$this->options->adminUrl();/ ?>manage-comments.php">评论</a>    -->
                    <!--    <a class="login-box-btn" href="<?php //$this->options->logoutUrl();/ ?>" title="Logout"><?php //_e('退出');/ ?> &raquo;</a>-->
                    <!--</div>-->
                    <?php else : ?>
                    <!--<form id="login-form-admin" class="login-form" style="display:none;" name="login" rold="form">-->
                    <!--    <label class="login-box-input-label" for="username" >用户名</label>-->
                    <!--    <input class="login-box-input" type="text" value="" name="username" id="username">-->
                    <!--    <label class="login-box-input-label" for="password" >密码</label>-->
                    <!--    <input class="login-box-input" type="password" value="" name="password" id="password">-->
                    <!--    <input class="login-box-remember" type="checkbox" value="" name="remember" id="remember">-->
                    <!--    <label class="login-box-input-label" for="login-box-remember" >记住密码</label>-->
                    <!--    <div class="btn-panel">-->
                    <!--    <input class="login-box-btn-w" type="button" value="访客" id="showguest">-->
                    <!--    <input class="login-box-btn" type="button" value="登录"  id="login-submit-btn">-->
                    <!--    <input type="hidden" name="referer" id="referer" value="<?php //$this->options->siteUrl(); ?>">-->
                    <!--    </div>-->
                    <!--</form><script>admin_login = false; </script>-->
                    <div id="login-form-admin" class="login-form" style="display:none;">
                        <div class="btn-panel">
                            <input class="login-box-btn-w" type="button" value="访客" id="showguest">
                            <input class="login-box-btn" type="button" value="后台" id="login-submit-btn">
                        </div>
                        <iframe id="login_iframe" width="100%" height="290px" src="<?php $this->options->adminUrl('login.php');
                            ?>" scrolling="no" frameborder="0"></iframe>

                    </div>
                    <form id="login-form-guest" class="login-form" style="">
                        <div class="btn-panel">
                            <input class="login-box-btn" type="button" value="访客" id="change_guest_info">
                            <input class="login-box-btn-w" type="button" value="后台" id="showlogin">
                        </div>
                        <input type="text" id="author" class="login-box-input" style="" placeholder="昵称*" value="<?php $this->remember('author');
                        ?>" required />
                        <input type="email" id="mail" class="login-box-input" style="" placeholder="邮箱*" value="<?php $this->remember('mail');
                        ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif;
                        ?> />
                        <input type="url" id="url" class="login-box-input" style="" placeholder="<?php _e('http://');
                        ?>" value="<?php $this->remember('url');
                        ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif;
                        ?> />
                    </form>
                    <?php endif;
                    ?>
                </div>

            </div>
        </nav>
        <!--导航结束-->

        <?php if ($this->is('index')): ?>


        <!--主体-->
        <div class="main-body ">

            <!--侧栏-->
            <?php if ($this->options->sidebar_stat == "l" || $this->options->sidebar_stat == "lr") : ?>
            <?php $this->need('sidebar-l.php');
            ?>
            <?php endif;
            //判断左栏结束 ?>
            <!--中间部分-->
            <div class="mid-body" id="mid-body">
                <!--面包屑导航-->
                <div class="breadcrumb load-a">
                    <div class="breadcrumb-content">
                        当前位置：<a href="<?php $this->options->siteUrl();
                            ?>" class="a">主页</a> &raquo;</li>
                    <?php if ($this->is('index')) : ?>
                    <!-- 页面为首页时 -->
                    <script>
                        var isindex = true;
                    </script>
                    最近文章
                    <?php elseif ($this->is('post')) : ?>
                    <!-- 页面为文章单页时 -->
                    <script>
                        var isindex = false;
                    </script>
                    <?php $this->category();
                    ?> &raquo; <?php $this->title() ?>
                    <?php else : ?>
                    <!-- 页面为其他页时 -->
                    <script>
                        var isindex = false;
                    </script>
                    <?php $this->archiveTitle(' &raquo; ', '', '');
                    ?>
                    <?php endif;
                    ?>
                </div>
            </div>
            <?php endif;
            //判断主页结束 ?>