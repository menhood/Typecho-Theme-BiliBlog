<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
//主题设置
function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以在网站标题后加上一个 LOGO'));
    $userboxpic = new Typecho_Widget_Helper_Form_Element_Text('userboxpic', NULL, 'https://i.loli.net/2018/10/19/5bc945e7ef153.png', _t('用户标签栏头部图片'), _t('在这里填入一个图片 URL 地址, 以在网站用户头像上加一个头图'));
    $userboxhead = new Typecho_Widget_Helper_Form_Element_Text('userboxhead', NULL, 'https://gravatar.loli.net/avatar/17842af77c9727c64e6468ad6d9d3f96', _t('用户头像'), _t('在这里填入一个图片 URL 地址, 以显示用户头像'));
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, 'https://i.loli.net/2018/10/26/5bd270b485abb.png', _t('站标'), _t('在这里填入一个图片 URL 地址, 以显示网站图标'));
    $Keywords = new Typecho_Widget_Helper_Form_Element_Text('Keywords', NULL, 'menhood,援军,个人博客,影视,后期', _t('Keywords'), _t('在这里填入Keywords, 用英文逗号隔开'));
    $Description = new Typecho_Widget_Helper_Form_Element_Text('Description', NULL, '这里是援军的博客，欢迎来访', _t('Description'), _t('在这里填入Description, 不要用英文引号'));
    $sidebar_stat = new Typecho_Widget_Helper_Form_Element_Text('sidebar_stat', NULL, 'lr', _t('Sidebar_Stat'), _t('在这里填入显示的侧栏，l为左，r为右,默认lr'));

    $form->addInput($logoUrl);
    $form->addInput($userboxpic);
    $form->addInput($userboxhead);
    $form->addInput($favicon);
    $form->addInput($Description);
    $form->addInput($Keywords);
    $form->addInput($sidebar_stat);
}
//初始化主题设置
function themeInit($archive) {
    //  Helper::options()->commentsAntiSpam = false;//关闭反垃圾
    Helper::options()->commentsMaxNestingLevels = 999;//设置评论最大层数
    
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.contents')))){
        $db->query('ALTER TABLE `'. $prefix .'contents` ADD `likes` INT(10) DEFAULT 0;');}
        
    if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.comments')))){
        $db->query('ALTER TABLE `'. $prefix .'comments` ADD `likes` INT(10) DEFAULT 0;');}
        
    if ($archive->is('archive',404)) {
        $path_info = trim($archive->request->getPathinfo(),'/');
        if (strpos($path_info,'action/like') !== false) {
            header("HTTP/1.1 200 OK");
            likeup($archive);
            $archive->response->goBack();
            exit;
        }
    }
}
//缩略图字段以及部分样式调整
function themeFields($layout) {
    $thumb = new Typecho_Widget_Helper_Form_Element_Text('thumb', NULL, NULL, _t('自定义缩略图'), _t('封面图地址'));
    $custom_text = new Typecho_Widget_Helper_Form_Element_Text('custom_text', NULL, NULL, _t('自定义文字'), _t('显示在主页卡片的标签旁边'));
    $post_type = new Typecho_Widget_Helper_Form_Element_Text('post_type', NULL, NULL, _t('文章类型'), _t('转载/原创'));
    $authority = new Typecho_Widget_Helper_Form_Element_Text('authority', NULL, NULL, _t('授权类型'), _t('随意转载/注明出处/禁止转载'));
    $post_author = new Typecho_Widget_Helper_Form_Element_Text('post_author', NULL, NULL, _t('文章作者'), _t('文章作者名称'));
    
    $layout->addItem($thumb);
    $layout->addItem($custom_text);
    $layout->addItem($post_type);
    $layout->addItem($authority);
    $layout->addItem($post_author);
}
//编辑页面底部插入自定义代码
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('add_c_c', 'add_custom_code');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('add_c_c', 'add_custom_code');
class add_c_c {
    public static function add_custom_code(){
         echo <<<EOF
<script>
$(document).ready(function() {
    //原创下拉菜单
    $("input[name='fields[post_type]']").attr("list","post_type_list");var post_type_list ='<datalist id="post_type_list"><option value="原创"><option value="转载"><option value="其他"></datalist>';$("input[name='fields[post_type]']").after(post_type_list);
    //授权下拉菜单
    $("input[name='fields[authority]']").attr("list","authority_list");var authority_list ='<datalist id="authority_list"><option value="禁止转载"><option value="注明出处"><option value="随意转载"></datalist>';$("input[name='fields[authority]']").after(authority_list);
    //作者署名
    var _author=document.getElementsByClassName("author")[0];var _post_author_input=document.getElementsByName("fields[post_author]")[0];_post_author_input.value = _author.innerText;
});
</script>
<style>/*owo表情样式*/.wmd-button-row {height:auto;}.OwO span{background:#fff0!important;width:auto!important;height:auto!important;}.OwO .OwO-body{top: 23px!important;width:480px!important;}input[type=text]{width:100%;}</style>
EOF;
}
}
/* 相关函数*/
//随机文章魔改版 原版来源：https://www.boke8.net/typecho-random-articles.html
function getRandomPosts($limit = 10){    
    $db = Typecho_Db::get();
    $result = $db->fetchAll($db->select()->from('table.contents')
		->where('status = ?','publish')
		->where('type = ?', 'post')
		->where('created <= unix_timestamp(now())', 'post')
		->limit($limit)
		->order('RAND()')
	);
	if($result){
		$i=1;
		foreach($result as $val){
			$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
			$post_title = htmlspecialchars($val['title']);
			$permalink = $val['permalink'];
			$post_date = date("m-d",$val['created']);
			$post_views = $val['views'];
            $thumb_result=$db->fetchAll($db->select()->from('table.fields')->where('name = ?','thumb')->where('cid = ?', $val['cid']));
            if(!empty($thumb_result)){
                $thumb_urls = $thumb_result[0]['str_value'];
                $val['thumb']=$thumb_urls;
            }else{
            	 $thumb_urls = "https://i.loli.net/2020/04/08/LE1KlIHzcxiRTDJ.jpg";
                $val['thumb']=$thumb_urls;
            };
			$post_thumb = $val['thumb'];
			echo '<li class="article-item"><a href="'.$permalink.'" title="'.$post_title.'" target="_blank"><div class="article-title">
                    <div class="label" title="'.$post_title.'">'.$post_title.'</div>
                        <div class="info">'.$post_date.' 阅读'.$post_views.'</div>
                    </div>
                    <div class="article-cover-holder" style="width: 68px;height: 50px;background-image:url('.$post_thumb.');    border-radius: 4px;overflow: hidden;vertical-align: middle;background-size: cover;background-position: 50%;background-repeat: no-repeat;">
                    </div></a></li>';
			$i++;
		}
	}
	
}
//点赞 出处：https://vircloud.net/typecho/typecho-self-path.html
function likeup($self) {
    if($self->request->filter('int')->cid){
        $cid = $self->request->filter('int')->cid;
        $self->db = Typecho_Db::get();
        $row = $self->db->fetchRow($self->db->select('likes')->from('table.contents')->where('cid = ?', $cid));
        $self->db->query($self->db->update('table.contents')->rows(array('likes' => (int)$row['likes']+1))->where('cid = ?', $cid));
        $self->response->throwJson("post like success");
    }elseif($self->request->filter('int')->coid){
        $coid = $self->request->filter('int')->coid;
        $self->db = Typecho_Db::get();
        $row = $self->db->fetchRow($self->db->select('likes')->from('table.comments')->where('cid = ?', $coid));
        $self->db->query($self->db->update('table.comments')->rows(array('likes' => (int)$row['likes']+1))->where('coid = ?', $coid));
        $self->response->throwJson("comment like success");
    }
}
function likesNum($coid=""){
    
        $db = Typecho_Db::get();
    if( $coid==""){
        $cid = Typecho_Widget::widget('Widget_Archive')->cid;
        $row = $db->fetchRow($db->select('likes')->from('table.contents')->where('cid = ?', $cid));
        if($row['likes']){
            echo $row['likes'];
        } 
    }else{
        $row = $db->fetchRow($db->select('likes')->from('table.comments')->where('coid = ?', $coid));
        if($row['likes']){
            echo $row['likes'];
        }
    }    
}
// 获取浏览量 出处：https://notemi.cn/typecho-theme-production-summary.html
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    }
    echo $row['views'];
}
//魔改获取总访问量 出处：https://sunpma.com/251.html
function get_author_AllViews($authorId)
{
    $db = Typecho_Db::get();
    $row = $db->fetchAll($db->select('SUM(VIEWS)')->from('table.contents')->where('authorId = ?', $authorId));
    echo number_format($row[0]['SUM(VIEWS)']);
}
function get_author_Allzans($authorId)
{
    $db = Typecho_Db::get();
    $row = $db->fetchAll($db->select('SUM(VIEWS)')->from('table.contents')->where('authorId = ?', $authorId));
    echo number_format($row[0]['SUM(VIEWS)']);
}
//上一篇
function prev_post($archive,$echo_type='',$default_text='')
{
    $db = Typecho_Db::get();
    $content = $db->fetchRow($db->select()
            ->from('table.contents')
            ->where('table.contents.created < ?', $archive->created)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $archive->type)
            ->where('table.contents.password IS NULL')
            ->order('table.contents.created', Typecho_Db::SORT_DESC)
            ->limit(1));
    if ($content)
    {
        if($echo_type == 'url'){
            $content = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($content);
            echo $content['permalink'];
        }else{
            $content = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($content);
            echo  $content['title']; 
        }
    }
    else
    {
        echo $default_text;
    }
}
//下一篇
function next_post($archive,$echo_type='',$default_text='')
{
    $db = Typecho_Db::get();
    $content = $db->fetchRow($db->select()
            ->from('table.contents')
            ->where('table.contents.created > ? AND table.contents.created < ?', $archive->created, Helper::options()->gmtTime)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $archive->type)
            ->where('table.contents.password IS NULL')
            ->order('table.contents.created', Typecho_Db::SORT_ASC)
            ->limit(1));
    if ($content)
    {
        if($echo_type == 'url'){
            $content = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($content);
            echo $content['permalink'];
        }else{
            echo  $content['title'];
        }
    }
    else
    {
        echo $default_text;
    }
}
//最大cid
function max_cid(){
    $db = Typecho_Db::get();
    $cmd_max_cid = $db->fetchRow($db->select('max(cid)')
            ->from('table.contents'));
    echo $cmd_max_cid['max(`cid`)'];
}

// 获取页面数据 出处：https://notemi.cn/typecho-theme-production-summary.html
function site_data() {
    $array = array(
        'site_url' => Helper::options()->siteUrl,
        'default_url' => Helper::options()->siteUrl . 'index.php',
        'theme_images_url' => Helper::options()->themeUrl . '/assets/images/',
    );
    echo json_encode($array);
}

//图片上传
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Utils', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Utils', 'addButton');
class Utils {
    public static function addButton(){
         echo <<<EOF
<script>
function close_img_panl(){
$('#upimgpanel').remove();
}
$(function() {
    var wmdf = $('#wmd-fullscreen-button');
    if (wmdf.length > 0) {
        wmdf.after(
            '<li class="wmd-button" id="wmd-ddns-image-button" style="padding-top:5px;" title="上传图片到图床">上传图片</li>');
    };
    $('#wmd-ddns-image-button').click(function() {
        $('body').append('<div id="upimgpanel">' +
            '<div class="wmd-prompt-background" style="position:absolute;z-index:1000;opacity:0.5;top:0px;left:0px;width:100%;height:954px;"></div>' +
            '<div class="wmd-prompt-dialog" style="top:150px;width:500px"><div><p><b>上传图片</b> <a href="https://img.menhood.wang/" target="_blank" >上传失败点这里</a><button onclick="close_img_panl()" style="float:right;">关闭</button></p></div>' +
            '<iframe width=500 height=600 src="https://img.menhood.wang/" style="border: 1px black;"></iframe></div></div>');
    });
    
});
</script>
EOF;
}
}
//添加网易云音乐
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('addaplayer', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('addaplayer', 'addButton');
class addaplayer {
    public static function addButton(){
         echo <<<EOF
<script>
function addaplayerinfo(){
    var id = document.getElementById("wyyid").value;
    var type = document.getElementById("datatype").value;
    var code = '\\n!!!\\n<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.css"><div id="haplayer"><\/div><script src="https://cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.js"><\/script><script>$.get("https://api.fczbl.vip/163/?server=netease&type='+type+'&id='+id+'",function(data){const hap = new APlayer({container: document.getElementById("haplayer"),listFolded: false,listMaxHeight: 90,lrcType: 3,audio: data});})<\/script>\\n!!!';
    insert(code);
    closeaddaplayer();
}
function insert(str){
    var tc = document.getElementById("text");
    var tclen = tc.value.length;
    tc.focus();
    if(typeof document.selection != "undefined")
    {
        document.selection.createRange().text = str;  
    }
    else
    {
        tc.value = tc.value.substr(0,tc.selectionStart)+str+tc.value.substring(tc.selectionStart,tclen);
    }
}
function closeaddaplayer(){
$('#addaplayer').remove();
}
$(function() {
    var wmdf = $('#wmd-ddns-image-button');
    if (wmdf.length > 0) {
        wmdf.after(
            '<li class="wmd-button" id="wmd-addaplayer-button" style="padding-top:5px;" title="插入网易云音乐"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAQAAABKfvVzAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAA6mAAAOpgAYTJ3nYAAAAHdElNRQfjAQkEIipnbIKcAAABy0lEQVQ4y43Tu2tTcRjG8c9Jgom9WGtvXjqkmqJTwcG/QKk4OdgWEUEQHRwcpaiDLhFEBAcH8YaD1EFc3CwODuLoVkQbtEIvSGkL9mJr0xyHnMY0F/Rdzvv78j6/97zPeQ//H4GkIPhnWYNWu6UdcMicG4maNzVotUdaRsZ+3TrtAO/FKgUZQ3r16NYRFbFm3hfb9NmgUnBEFqyaN25CTs5Xk2YMekK1AL677ZMps5bkSzTKagmmPPOriob1BUEVjUtpry8I5RHXpF23Hr0y0nrqC9qct09G2l5tUhFdrycoOOh+lC+aMembcZ8ddrW2ILDio5ycnAnT5q0IkazXITBmwI8qHi8+YjVmyFveco5JYqO6Q0whwn9XstlJ/TpMbw5fFKQc1a/LtIYKv+45s/UtEmiWdbFkX3lccNaCEWP6nLZzE19SsGzENc/9FPqgGWz3VuhmVHVL6J2mhKQTAg8My4vLGi774mHJnUAci9YT0eYsy2PDElaizVz1xjGXdRnTZxCj1uCK0Jy7zrljVuh6qccuT60LhUK/PdRSxO1eKEQ49FJn2diNhjz22iMDRQeLjrc45bhOs0a9slDlVqLsRyqDjTV3tyL+AOxCe+HCKfjPAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDE5LTAxLTA5VDA0OjM0OjQyKzA4OjAwWFoIWAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxOS0wMS0wOVQwNDozNDo0MiswODowMCkHsOQAAABDdEVYdHNvZnR3YXJlAC91c3IvbG9jYWwvaW1hZ2VtYWdpY2svc2hhcmUvZG9jL0ltYWdlTWFnaWNrLTcvL2luZGV4Lmh0bWy9tXkKAAAAGHRFWHRUaHVtYjo6RG9jdW1lbnQ6OlBhZ2VzADGn/7svAAAAGHRFWHRUaHVtYjo6SW1hZ2U6OkhlaWdodAAxNDliIdaQAAAAF3RFWHRUaHVtYjo6SW1hZ2U6OldpZHRoADE0OIbXtlsAAAAZdEVYdFRodW1iOjpNaW1ldHlwZQBpbWFnZS9wbmc/slZOAAAAF3RFWHRUaHVtYjo6TVRpbWUAMTU0Njk3OTY4MhZlLaIAAAARdEVYdFRodW1iOjpTaXplADIyMDZCJTfZHQAAAGJ0RVh0VGh1bWI6OlVSSQBmaWxlOi8vL2hvbWUvd3d3cm9vdC9uZXdzaXRlL3d3dy5lYXN5aWNvbi5uZXQvY2RuLWltZy5lYXN5aWNvbi5jbi9maWxlcy8xMjIvMTIyMjYzNy5wbmdQaBQPAAAAAElFTkSuQmCC" width=20 height=20 /></li>');
    };
    $('#wmd-addaplayer-button').click(function() {
        $('body').append('<div id="addaplayer">' +
            '<div class="wmd-prompt-background" style="position:absolute;z-index:1000;opacity:0.5;top:0px;left:0px;width:100%;height:954px;"></div>' +
            '<div class="wmd-prompt-dialog"><div><p><b>添加音乐</b> <button onclick="closeaddaplayer()" style="float:right;">关闭</button></p></div>' +
            '歌曲/歌单id：<input type="text" id="wyyid" >type：<select id="datatype"><option value ="song">单首</option><option value ="playlist">歌单</option></select><input type="button" value="插入" onclick="addaplayerinfo()" ></div></div>');
    });
    
});
</script>
EOF;
    }
}
//添加视频
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('adddplayer', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('adddplayer', 'addButton');
class adddplayer {
    public static function addButton(){
         echo <<<EOF
<script>
function adddplayerinfo(){
    var url = document.getElementById("dpurl").value;
    var api = document.getElementById("dpapi").value;
    var dm = document.getElementById("dpdm").checked;
    var autoplay = document.getElementById("dpautoplay").checked;
    var loop = document.getElementById("dploop").checked;
    var code='';
    if(!dm){
     code = '\\n!!!\\n<link href="https://cdnjs.loli.net/ajax/libs/dplayer/1.25.0/DPlayer.min.css" rel="stylesheet"><div id="dplayer"><\/div><script src="https://cdnjs.loli.net/ajax/libs/dplayer/1.25.0/DPlayer.min.js"><\/script><script>const dp = new DPlayer({container: document.getElementById("dplayer"),loop:'+loop+',autoplay:'+autoplay+',video: {url: "'+url+'"}});<\/script>\\n!!!';
    }else{
     code = '\\n!!!\\n<link href="https://cdnjs.loli.net/ajax/libs/dplayer/1.25.0/DPlayer.min.css" rel="stylesheet"><div id="dplayer"><\/div><script src="https://cdnjs.loli.net/ajax/libs/dplayer/1.25.0/DPlayer.min.js"><\/script><script src="https://cdnjs.loli.net/ajax/libs/blueimp-md5/2.10.0/js/md5.min.js"><\/script><script>var url="'+url
        +'";const dp = new DPlayer({container: document.getElementById("dplayer"),loop:'+loop
        +',autoplay:'+autoplay
        +',video: {url: url},danmaku: {id: md5(url),api: "'+api
        +'",token: "tokendemo",bottom: "15%"}});<\/script>\\n!!!';
    }
    insert(code);
    closeadddplayer();
}
function insert(str){
    var tc = document.getElementById("text");
    var tclen = tc.value.length;
    tc.focus();
    if(typeof document.selection != "undefined")
    {
        document.selection.createRange().text = str;  
    }
    else
    {
        tc.value = tc.value.substr(0,tc.selectionStart)+str+tc.value.substring(tc.selectionStart,tclen);
    }
}
function closeadddplayer(){
$('#adddplayer').remove();
}
$(function() {
    var wmdf = $('#wmd-addaplayer-button');
    if (wmdf.length > 0) {
        wmdf.after(
            '<li class="wmd-button" id="wmd-adddplayer-button" style="padding-top:5px;" title="插入视频"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAGpWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDIgNzkuMTYwOTI0LCAyMDE3LzA3LzEzLTAxOjA2OjM5ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOS0wMi0xOVQxMzowMDoxNCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTktMDItMTlUMTM6MDE6MzIrMDg6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMTktMDItMTlUMTM6MDE6MzIrMDg6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiBJRUM2MTk2Ni0yLjEiIHBob3Rvc2hvcDpIaXN0b3J5PSIyMDE5LTAyLTE5VDEzOjAxOjEyKzA4OjAwJiN4OTvmlofku7YgZHBsYXllci5wbmcg5bey5omT5byAJiN4QTsyMDE5LTAyLTE5VDEzOjAxOjMyKzA4OjAwJiN4OTvmlofku7YgRDpcUGljdHVyZXNcU2F2ZWQgUGljdHVyZXNc5Zu+5qCHXGRwbGF5ZXIyNF8yNC5wbmcg5bey5a2Y5YKoJiN4QTsiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ZmIyOWMzOWUtMGY2MC0wZDQ5LTgxOTktNjIzY2MyZjc4NGUwIiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6OTI5MWIxMTEtMTU3NC0yODRiLTg5MTgtMWYzMTIwMDk1OTFmIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6NWE0M2Q0MGUtOGY2Ni0yMDQ3LWJmZDktODM4OWExZmM3YmUwIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1YTQzZDQwZS04ZjY2LTIwNDctYmZkOS04Mzg5YTFmYzdiZTAiIHN0RXZ0OndoZW49IjIwMTktMDItMTlUMTM6MDA6MTQrMDg6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cykiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmZiMjljMzllLTBmNjAtMGQ0OS04MTk5LTYyM2NjMmY3ODRlMCIgc3RFdnQ6d2hlbj0iMjAxOS0wMi0xOVQxMzowMTozMiswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6qHOR3AAAEBklEQVRIx52WfUxVdRjHn0wN0t6GE002lugiBTTFYTlXWhg6zJqxoSt6UWQhzSwobc2WW7Pa2tBJXbhAwOXyOujey+QSIlACBijEqKFCo+giN7mE8qKAsk9/nEP3wL0i89l+O7895/y+3+ft9zxHZFqZJQEbIv1j47+MTjqZlJhv0BkLDDpj0smk43EJX8UEbdy1QmSO3JO8+s7n4dWVpgpsKeBIgO7t0BEM7cFgCwdHPNh0nK02VUXEfPHKjIHne63yLKpuyuNWPvy+BgoFsgXyRNkXqvtsdd8aBLdyKKn5tfgx73UPTQu+eOmmhZ39tnauRTtBzQKmOyyz+o1BwBGFbdD2p69/mI9b8Ae8AufY/u3ppGsDpLkB+0GgWH26I0sT6Ajm6lDPlfmLgj1dCErL6k0MR4BeY7VZoEAgSyBHtdaoWlwkYNEQWARSBa6HU1Xd9KPIbCd4aMThTZCnAGndzxIwPwytCdBjht5K+DsHzkdBvkpmmXImQ4BMdkQd3arCz5XmuooGOvwUK80a8Krn4aYdt9JXD+YFriS5Am1LuNh4ulXkQZFlwZFP0J/uTKhZtaxsGXeVGx1QMEupJq0XOQIDelY9t3elHPjkRCzDCZCpSWa2gKNqCliXe5K2w86zEytLYCiOj44kfiB6vV6HfZvimklNZLmPK9BpPygNgNG+yfrBS4oHRRqCPIHuF8hIT0mVolxdPu1BTjezBWo3uxKcWQmJAubZcPuGUz/WDyVzlWqbICgUuBTAmdKcUinO1RVMIjAKnF3vSmD1huMCPz8L4yNO/agDSjzcElRac0slVZ+STE+Y4tbES8s8GB+bTFAXBg1vuRKPXFUuYOGUENk2k/m9Pk0OfnoijuEPJycqQ+DyUWYk42NgXQzpmnLNEhiK5dBnifHyZMhuP66lOj0waRpaX83MSAbawLpCCdNEmQ+ksGZzTJCIeEprfUUTl32dlWRRL0yBQPtJ13C5k5udyhmjwG/etF8obxOZr9zlbbuPhIJhcpgsKoFBwLoEGl6D5r3QvA+aozVrH1x4E35ar9yhdAH07Nxz7GVNq7tfKirPW7m+XWlY2mZnEqXvGNTYulsG9Zt0gb5QautaqkU8JnfTeQvXePwzaO/mj7Xu27XpLnMhTeBiIP2j9t5HfZ5xP3h8/cN8uodsf+F4XbFsJgMnX5TQ2iPoHbFdWR64Y+m0U83r8ZBHTp1rMXHbCC1POdtyvmZkTujyBJqXw+1MyhtbTy3y3bhgxrN51/6vd/5SW1JDTzL07oeul+Dy03BpNXRtgd53wa6jsc5y7o0D30SK3Hcv/xaesu7Ft1e///GxOH1y8rdWU7a5zGw0p6Ykf3fw0LH3QrbsWft/Kd5B/gORZ1qaUwWnOQAAAABJRU5ErkJggg==" width=20 height=20 /></li>');
    };
    $('#wmd-adddplayer-button').click(function() {
        $('body').append('<div id="adddplayer">' +
            '<div class="wmd-prompt-background" style="position:absolute;z-index:1000;opacity:0.5;top:0px;left:0px;width:100%;height:954px;"></div>' +
            '<div class="wmd-prompt-dialog"><div><p><b>添加视频</b> <button onclick="closeadddplayer()" style="float:right;">关闭</button></p></div>' +
            '直链地址：<input type="text" id="dpurl" >api服务器地址：<input type="text" id="dpapi" value="https://dans.mdh.red/">弹幕：<input type="checkbox" id="dpdm">自动播放：<input type="checkbox" id="dpautoplay">循环：<input type="checkbox" id="dploop"><input type="button" value="插入" onclick="adddplayerinfo()" ></div></div>');
    });
    
});
</script>
EOF;
    }
}

//owo
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('addowo', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('addowo', 'addButton');
class addowo {
    public static function addButton(){
         echo <<<EOF
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/menhood/owo@2020-04-06/dist/OwO.min.css">
<script src="https://cdn.jsdelivr.net/gh/menhood/owo@2020-04-06/dist/OwO.min.js"></script>
<script>

function loadowo(){
    var OwO_demo = new OwO({logo: "<img src=\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAgMAAABinRfyAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAxQTFRFAAAAm6Kpg4ySmKCoOQPxiAAAAAR0Uk5TACuS9QkrIZAAAABMSURBVHicY2DI/8nAwPT/fwMD/xPpDwz6Dow/GGoZgGiHjY0ewxcbG3mGDzY2/AwfHBj5Gb4s4JJn2FGhq8dQK/2kFqIYrA1sAMgoAA+HGngFiloFAAAAAElFTkSuQmCC\'>",container: document.getElementById("OwO"),target: document.getElementById("text"),api: "https://cdn.jsdelivr.net/gh/menhood/owo@2020-04-06/dist/OwO.json",position: "down",width: "100%",maxHeight: "250px"});
}
$(function() {
    var wmdf = $('#wmd-adddplayer-button');
    if (wmdf.length > 0) {
        wmdf.after('<div id="OwO" class="OwO" style="position: absolute;vertical-align: baseline;display: inline-block;margin: 0;margin-top: 3px;"></div><script>loadowo();<\/script>');
        
    };
});
</script>
EOF;
}
}

//添加tip
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('addtip', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('addtip', 'addButton');
class addtip {
    public static function addButton(){
         echo <<<EOF
<script>
function addtip(type){
    var code = '!!!\\n<p class="'+ type +'">\\n\\n<\/p>\\n!!!';
    insert(code);
    closeaddtip();
}
function insert(str){
    var tc = document.getElementById("text");
    var tclen = tc.value.length;
    tc.focus();
    if(typeof document.selection != "undefined")
    {
        document.selection.createRange().text = str;  
    }
    else
    {
        tc.value = tc.value.substr(0,tc.selectionStart)+str+tc.value.substring(tc.selectionStart,tclen);
    }
}
function closeaddtip(){
$('#addtip').remove();
}
$(function() {
    var wmdf = $('#wmd-editarea');
    if (wmdf.length > 0) {
        wmdf.after(
            '<style>p.tip{border-left-color:#3c763d;background-color:rgba(241,249,241,.83)}p.tip:before{background-color:#3c763d}p.warning{border-left-color:#f7d24c;background-color:#fefbed}p.warning:before{background-color:#f7d24c}p.danger{border-left-color:#f66;background-color:hsla(0,100%,70%,.06)}p.danger:before{background-color:#f66}p.danger:before,p.tip:before,p.warning:before{content:"!";position:absolute;top:14px;left:-12px;color:#fff;width:20px;height:20px;border-radius:100%;text-align:center;line-height:20px;font-weight:700;font-family:Dosis,Source Sans Pro,Helvetica Neue,Arial,sans-serif}p.danger,p.tip,p.warning{padding:12px 24px 12px 20px;margin:2em 0;border-left:4px solid;position:relative;border-bottom-right-radius:2px;border-top-right-radius:2px}<\/style><li style="float:left;list-style:none;cursor: pointer;"><p class="tip" style="width:50px;margin: 0;" onclick="addtip(\'tip\')" >正常<\/p><\/li><li style="float:left;list-style:none;cursor: pointer;"><p class="warning" style="width:50px;margin: 0;" onclick="addtip(\'warning\')" >警告<\/p><\/li><li style="float:left;list-style:none;cursor: pointer;"><p class="danger" style="width:50px;margin: 0;" onclick="addtip(\'danger\')" >危险<\/p><\/li><div style="clear: both;"><\/div>');
    };
    
});
</script>
EOF;
    }
}
//时间转换，距离当前时间
function timesince($older_date,$comment_date = false) {
$chunks = array(
array(86400 , '天'),
array(3600 , '小时'),
array(60 , '分'),
array(1 , '秒'),
);
$newer_date = time();
$since = abs($newer_date - $older_date);
if($since < 2592000){
for ($i = 0, $j = count($chunks); $i < $j; $i++){
$seconds = $chunks[$i][0];
$name = $chunks[$i][1];
if (($count = floor($since / $seconds)) != 0) break;
}
$output = $count.$name.' 前';
}else{
$output = !$comment_date ? (date('Y-m-j G:i', $older_date)) : (date('Y-m-j', $older_date));
}
return $output;
}
// 等级样式
function get_level($guest_mail){
$db=Typecho_Db::get();
$mail=$db->fetchAll($db->select(array('COUNT(cid)'=>'count_comment'))->from('table.comments')->where('mail = ?', $guest_mail)->where('authorId = ?','0'));
foreach ($mail as $sl){
$count_comment=$sl['count_comment'];}
if($count_comment<1){
echo 'l0';
}elseif ($count_comment<10 && $count_comment>0) {
echo 'l1';
}elseif ($count_comment<20 && $count_comment>=10) {
echo  'l2';
}elseif ($count_comment<30 && $count_comment>=20) {
echo  'l3';
}elseif ($count_comment<40 && $count_comment>=30) {
echo  'l4';
}elseif ($count_comment<50 && $count_comment>=40) {
echo  'l5';
}elseif ($count_comment<60 && $count_comment>=50) {
echo  'l6';
}elseif ($count_comment<70 && $count_comment>=60) {
echo  'l7';
}elseif ($count_comment<80 && $count_comment>=70) {
echo  'l8';
}elseif ($count_comment>=80) {
echo  'l9';
}
}
// 评论加@
function get_comment_at($coid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ? AND status = ?', $parent, 'approved'));
        $author = $arow['author'];
        $href   = '<a  href="#comment-' . $parent . '">@' . $author . '</a>';
        echo $href;
    } else {
        echo '';
    }
}