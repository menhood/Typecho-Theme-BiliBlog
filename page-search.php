<?php
/**
 * Template Page of Search
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>

<?php $this->need('header.php');
?>

<!--中间部分-->

<script>
    // 改标题，改样式
    isindex = false;
    $(document).attr("title", "<?php $this->title() ?>");
    $('body').css("background", "#fff");
</script>

<form id="searchform" action="<?php $this->options->siteUrl();
    ?>" method="post">

    <div class="search-b">
        
        <div class="search-b-head"><div class="search-b-head-title"><?php $this->options->title();?></div></div>
        <div class="search-b-bar">
            <div id="search-b-type" class="b-slt">
                <span class="txt">本站搜索</span><div class="b-slt-arrow"></div>
            </div>
            <input type="text" class="search-b-content" id="search-b-content" name="s" value="" autocomplete="off" placeholder="搜索你想要的内容...">
            <a class="search-b-sureBtn" id="search_b_sureBtn" onclick="ssub()">搜 索</a>
        </div>
        <div class="search-b-tips clear">
            <ul class="search-b-tipsLink">
                <li><a href="<?php $this->options->siteUrl(); ?>index.php/about.html"><i class="search-icons icons-bangumi"></i><span>留言板</span></a></li>
                <li><a href="<?php $this->widget('Widget_Comments_Recent','pageSize=1')->parse('{permalink}');?>"><i class="search-icons icons-nowtopic"></i><span>最新评论</span></a></li>
                <li><a href="<?php $this->options->siteUrl(); ?>index.php/timeline.html"><i class="search-icons icons-allwebsite"></i><span>全站归档</span></a></li>
            </ul>
        </div>
        <div class="search-b-suggest clear">
            <div class="search-b-hotSearch">
                <div class="search-b-title">
                    <i class="search-b-title-icon hot"></i>热门搜索<span class="search-b-subTitle">Daily Hot</span>
                </div>
                <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags);
                ?>
                <ul class="search-b-history">
                    <?php while ($tags->next()): ?>
                    <li><a style="color: #222;" href="<?php $tags->permalink();
                        ?>" title='<?php $tags->name();
                        ?>'><?php $tags->name();
                        ?></a></li>
                    <?php endwhile;
                    ?>
                </ul>
            </div>
            <div class="search-b-searchHistory">
                <div class="search-b-title">
                    <i class="search-b-title-icon history"></i>搜索历史<span class="search-b-deleteHistory" id="search-b-deleteHistory"><i class="icon-garbage"></i>清空</span><span class="search-b-subTitle">History</span>
                </div>
                <ul class="search-b-history" id="s_history">
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</form>
<script>
$(function() {
    show_s_history();
});
function show_s_history(){
    var s_history_html = "",
        s_history_content = localStorage.historyItems.split("|");
    $.each(s_history_content,function(i,v){
        s_history_html += '<li><a href="javascript:void(0);" onclick="his_to_s(\''+ v +'\')" >'+v+'</a></li>';
    });
    $("#s_history").html(s_history_html);
}    
    $("#search-b-deleteHistory").click(function(){
        $("#s_history").html("已清空");
        localStorage.removeItem('historyItems'); 
    })
    function ssub() {
        var keyword = document.getElementById("search-b-content").value;
        setHistoryItems(keyword);
        document.getElementById("searchform").submit();
    }
function his_to_s(his_text){
    $("#search-b-content").val(his_text); 
    $("#search_b_sureBtn").trigger("click");
}
</script>

<?php $this->need('footer.php');
?>