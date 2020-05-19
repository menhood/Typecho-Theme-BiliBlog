<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>


<!--底部footer-->
<!--<div class="footer " id="footer">-->
<!--<span style="font-size:12px;color:#99a2aa">下面啥也木有</span>-->
<!--</div>-->

<?php $this->footer();
?>

<script type="text/javascript" data-no-instant="true" src="<?php echo $this->options->rootUrl;
?>/usr/themes/biliblog/static/js/biliblog.js"></script>
<script src="<?php $this->options->themeUrl('static/js/prism.js'); ?>"></script>
<script>
//赋值
login_url = "<?php $this->options->loginAction()?>";
//文章点赞
$(document).on('click', '.like_btns' ,function(e) {
    var id = $(this).attr('data-cid');
    var num = $(this).attr('data-num');
    $.ajax({
        type: 'post',
        url: '<?php Helper::options()->index('/action/like'); ?>',
        data:{cid: id},
        success: function(data) {
            console.log(data);
            // console.log(textStatus);
            // console.log(XMLHttpRequest);
            if (data == "post like success") {
                num++;
                var i_id = "#like_i_"+id,s_id = "#like_s_"+id;
                $(i_id).attr("class","custom-like-icon zan-active");
                $(s_id).text(num);
            };
        },
        error: function(data) {
            console.log(data);
            $.jGrowl.defaults.position = 'center';
            $.jGrowl('点赞失败！');
        }
    });
});
//评论点赞
$(document).on('click', '.info .like' ,function(e) {
    var coid = $(this).attr('data-coid');
    var num = $(this).attr('data-num');
    $.ajax({
        type: 'post',
        url: '<?php Helper::options()->index('/action/like?type=comment'); ?>',
        data:{coid: coid},
        success: function(data) {
            console.log(data);
            if (data == "comment like success") {
                num++;
                var i_id = "#comment-"+coid+"_like",s_id = "#cmt_zan_num_"+coid;
                $(i_id).attr("class","like like-active ");
                $(s_id).text(num);
            };
        },
        error: function(data) {
            console.log(data);
            $.jGrowl.defaults.position = 'center';
            $.jGrowl('点赞失败！');
        }
    });
});
//切换tab显示文字
var OriginTitile = document.title;
var titleTime;
var OriginIco = document.getElementById("tabico").href;
document.addEventListener('visibilitychange', function() {
if (document.hidden) {
document.title = '(つェ⊂) 信号搜寻中··· ' + OriginTitile;
clearTimeout(titleTime);
document.getElementById("tabico").href = "https://i.loli.net/2018/10/26/5bd287ccc93fe.png";
} else {
document.title = '(*´∇｀*) 找到信号辣！ ' + OriginTitile;
document.getElementById("tabico").href = OriginIco;
titleTime = setTimeout(function() {
document.title = OriginTitile;
}, 2000);
}
});
</script>
</body>

</html>