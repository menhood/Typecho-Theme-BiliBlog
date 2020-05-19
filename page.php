<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<?php $this->need('header.php');
?>

<!--中间部分-->
<script>
    isindex = false;
    $(document).attr("title", "<?php $this->title() ?>");
    $("body").attr("style", "background:#fff");
</script>
<!--文章主体-->
<div class="post-container">

    <?php $this->need('sidebar-l.php');
    ?>
    <?php $this->need('sidebar-r.php');
    ?>
    <div class="head-container">
        <?php if ($this->fields->thumb): ?>
        <div class="post-head blur" style="background-image: url(<?php $this->fields->thumb();
            ?>);background-position-x:center;background-position-y:center;width:100%;height:100px;">
        </div>
        <?php endif;
        ?>
        <div class="argue-flag hidden"></div>
        <div class="title-container">
            <h1 class="title"><?php $this->title() ?></h1>
            <div class="info">
                <a class="category-link" href="//www.bilibili.com/read/life#rid=15" target="_blank"><span><?php $this->category(',');
                    ?></span></a>
                <span class="create-time"><?php _e('时间: ');
                    ?><time datetime="<?php $this->date('c');
                        ?>" itemprop="datePublished"><?php $this->date();
                        ?></time></span>
                <div class="article-data">
                    <span><?= get_post_view($this);
                        ?>阅读</span>
                    <span> <?php $this->likesNum();
                        ?>点赞</span>
                    <span><?php $this->commentsNum('%d');
                        ?>评论</span>
                    <?php if($this->user->hasLogin()):?><span><a href="<?php $this->options->adminUrl('write-post.php')?>/write-post.php?cid=<?php echo $this->cid;?>" target="_blank">编辑</a></span><?php endif;?>    
                </div>
            </div>
        </div>
    </div>

    <article class="post-content">
        <?php $this->content();
        ?>
    </article>

    <div class="article-action">
        <div class="ops like_btns" data-cid="<?php $this->cid();
            ?>" data-num="<?php likesNum();
            ?>">
            <span class="like-btn ">
                <i class="icon-video-details_like" id="like_i_<?php $this->cid();
                    ?>"></i>
                <span id="like_s_<?php $this->cid();
                    ?>"><?php likesNum();
                    ?></span>
            </span>
            <span class="share-container share-btn">
                点击复制：<span>
                    <script src="<?php $this->options->themeUrl('static/js/qrcode.min.js');
                        ?>"></script>
                    <script src="<?php $this->options->themeUrl('static/js/clipboard.min.js');
                        ?>"></script>
                    <a href="javascript:void(0)" id="copy_url"><i class="icon-share_news_default" title="复制链接" ><div id="qrcode_url_box" class="qrbox-holder" style="z-index:3;"></div>
                    </i></a>

                </span>
            </span>

            <script>
                $(function() {
                    new QRCode(document.getElementById("qrcode_url_box"), {
                        text: _now_url,
                        width: 148,
                        height: 148,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                });
                $("#copy_url").hover(function() {
                    $("#qrcode_url_box").toggle();
                });
                $("#copy_url").click(function() {
                    $("#copy_url").attr("data-clipboard-text", _now_url)
                    var clipboard = new ClipboardJS('#copy_url');
                    clipboard.on('success', function (e) {
                        $.jGrowl.defaults.position = 'center';
                        $.jGrowl('本文地址复制成功！');
                    });
                });
            </script>
        </div>
    </div>
    
    <?php $this->need('comments.php');
    ?>
    <script>
        var imgs = $(".post-content img:not(.smilies)");
        for (i = 0; i < imgs.length; i++) {
            var imgs = $(".post-content img:not(.smilies)");
            imgs[i].outerHTML = '<a href="' + imgs[i].src +' "data-fancybox="images" data-caption="' + imgs[i].alt + '" >' + '<div class="post-img"><img data-original="'+imgs[i].src+'" src="https://i.loli.net/2018/10/30/5bd8193caea80.gif" class="lazyload" alt="'+ imgs[i].alt +'" title="'+ imgs[i].title +'"></div>' + '<\/a>';
        };
        $('[data-fancybox="images"]').fancybox({
            'transitionIn': 'elastic', //窗口显示的方式
            'transitionOut': 'elastic'
        });
        $("img.lazyload").lazyload({
            effect: 'fadeIn'
        });
    </script>
</div>
</div>
</div>


<!--</div> end #main-->
<?php $this->need('footer.php');
?>