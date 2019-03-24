<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, 'https://i.loli.net/2018/10/26/5bd270b485abb.png', _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以在网站标题后加上一个 LOGO'));
    $userboxpic = new Typecho_Widget_Helper_Form_Element_Text('userboxpic', NULL, 'https://i.loli.net/2018/10/19/5bc945e7ef153.png', _t('用户标签栏头部图片'), _t('在这里填入一个图片 URL 地址, 以在网站用户头像上加一个头图'));
    $userboxhead = new Typecho_Widget_Helper_Form_Element_Text('userboxhead', NULL, 'https://gravatar.loli.net/avatar/17842af77c9727c64e6468ad6d9d3f96', _t('用户头像'), _t('在这里填入一个图片 URL 地址, 以显示用户头像'));
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, 'https://i.loli.net/2018/10/26/5bd270b485abb.png', _t('站标'), _t('在这里填入一个图片 URL 地址, 以显示网站图标'));
    $musicindex = new Typecho_Widget_Helper_Form_Element_Text('musicindex', NULL, 'https://music.163.com/#/user/home?id=87888813', _t('网易云音乐首页'), _t('在这里填入一个 URL 地址, 以跳转网易云音乐个人主页'));
    $bilibiliindex = new Typecho_Widget_Helper_Form_Element_Text('bilibiliindex', NULL, 'https://space.bilibili.com/2645858/#/', _t('哔哩哔哩空间主页'), _t('在这里填入一个 URL 地址, 以跳转哔哩哔哩空间主页'));
    $apid= new Typecho_Widget_Helper_Form_Element_Text('apid', NULL, '100845969', _t('网易云音乐id'), _t('在这里填入id数字, 以播放网易云音乐歌单'));
    $Keywords= new Typecho_Widget_Helper_Form_Element_Text('Keywords', NULL, 'menhood,援军,个人博客,影视,后期', _t('Keywords'), _t('在这里填入Keywords, 用英文逗号隔开'));
    $Description= new Typecho_Widget_Helper_Form_Element_Text('Description', NULL, '这里是援军的博客，欢迎来访', _t('Description'), _t('在这里填入Description, 不要用英文引号'));
    $lanshu= new Typecho_Widget_Helper_Form_Element_Text('lanshu', NULL, '3', _t('显示模式'), _t('在这里填入栏数，纯数字，支持单栏，双栏，三栏'));
    
    $form->addInput($logoUrl);
    $form->addInput($userboxpic);
    $form->addInput($userboxhead);
    $form->addInput($favicon);
    $form->addInput($bilibiliindex);
    $form->addInput($musicindex);
    $form->addInput($apid);
    $form->addInput($Description);
    $form->addInput($Keywords);
    $form->addInput($lanshu);
    
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    array('ShowOwO' => _t('显示OwO表情'),
    'ShowTOC' => _t('显示TOC目录')
    ),
    array('ShowOwO', 'ShowTOC'), _t('侧边栏显示'));
    
    $form->addInput($sidebarBlock->multiMode());
}


function themeInit($archive)
{
 Helper::options()->commentsAntiSpam = false;
 Helper::options()->commentsMaxNestingLevels = 3;
}

function is_pjax()
{
    return (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true');
}


//图片上传功能，粗略完成
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Utils', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Utils', 'addButton');

class Utils {
    public static function addButton(){
         echo <<<EOF
        
<script>
function closepanl(){
$('#upimgpanel').remove();
}
$(function() {
    var wmdf = $('#wmd-fullscreen-button');

    if (wmdf.length > 0) {
        wmdf.after(
            '<li class="wmd-button" id="wmd-ddns-image-button" style="padding-top:5px;" title="上传图片">上传图片</li>');
    };
    $('#wmd-ddns-image-button').click(function() {
        $('body').append('<div id="upimgpanel">' +
            '<div class="wmd-prompt-background" style="position:absolute;z-index:1000;opacity:0.5;top:0px;left:0px;width:100%;height:954px;"></div>' +
            '<div class="wmd-prompt-dialog"><div><p><b>上传图片</b> <button onclick="closepanl()" >关闭</button></p></div>' +
            '<iframe width=500 height=600 src="https://ddns.menhood.wang:2000/" style="border: 1px black;"></iframe></div></div>');
    });
    
});
</script>
EOF;
    }
}