<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!--TO-TOP-->
<p id="to-top"><a href="#top"><span></span></a></p>

<!--底部footer-->
                            <div class="row clearfix">
                                <div class="col-md-12 column">
                                    <div class="footer text-center">
                                    <a href="<?php $this->options->adminUrl('login.php'); ?>" class="a">&copy;</a>2015-<?php echo date('Y'); ?> 
                                    <a href="<?php $this->options->siteUrl(); ?>" class="a">
                                        <?php $this->options->title(); ?>
                                    </a>
                                    <?php _e('由 <a href="http://www.typecho.org" class="a">Typecho</a> 强力驱动'); ?>. 
                                    Theme <a href="http://menhood.wang" class="a">BiliBlog</a> 
                                    <br>
                                    <a href="<?php $this->options->feedUrl(); ?>" target="_blank" class="a">文章RSS</a> <!-- 文章的RSS地址连接 -->|
                                    <a href="<?php $this->options->commentsFeedUrl(); ?>" target="_blank" class="a">评论RSS</a>. <!-- 评论的RSS地址连接 -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->footer(); ?>

        <script type="text/javascript" data-no-instant="true" src="/usr/themes/biliblog/biliblog.js"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123390780-1"></script>
        <script>
        var OriginTitile = document.title;
        var titleTime;
        var OriginIco = document.getElementById("tabico").href;
        document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        document.title = '(つェ⊂) 信号搜寻中··· ' + OriginTitile;
        clearTimeout(titleTime);
        document.getElementById("tabico").href="https://i.loli.net/2018/10/26/5bd287ccc93fe.png";
    }
    else {
        document.title = '(*´∇｀*) 找到信号辣！ ' + OriginTitile;
        document.getElementById("tabico").href=OriginIco;
        titleTime = setTimeout(function() {
            document.title = OriginTitile;
        }, 2000);
    }
});
        </script>
    </body>

</html>


