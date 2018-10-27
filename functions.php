<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, 'https://i.loli.net/2018/10/26/5bd270b485abb.png', _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以在网站标题后加上一个 LOGO'));
    $userboxpic = new Typecho_Widget_Helper_Form_Element_Text('userboxpic', NULL, 'https://i.loli.net/2018/10/19/5bc945e7ef153.png', _t('用户标签栏头部图片'), _t('在这里填入一个图片 URL 地址, 以在网站用户头像上加一个头图'));
    $userboxhead = new Typecho_Widget_Helper_Form_Element_Text('userboxhead', NULL, 'https://gravatar.loli.net/avatar/17842af77c9727c64e6468ad6d9d3f96', _t('用户头像'), _t('在这里填入一个图片 URL 地址, 以显示用户头像'));
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, 'https://i.loli.net/2018/10/26/5bd270b485abb.png', _t('站标'), _t('在这里填入一个图片 URL 地址, 以显示网站图标'));
    $form->addInput($logoUrl);
    $form->addInput($userboxpic);
    $form->addInput($userboxhead);
    $form->addInput($favicon);
    
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    array('ShowRecentPosts' => _t('显示最新文章'),
    'ShowRecentComments' => _t('显示最近回复')),
    array('ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowArchive', 'ShowOther'), _t('侧边栏显示'));
    
    $form->addInput($sidebarBlock->multiMode());
}


/*
function themeFields($layout) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个LOGO'));
    $layout->addItem($logoUrl);
}
*/
function themeInit($archive)
{
 Helper::options()->commentsAntiSpam = false;
 Helper::options()->commentsMaxNestingLevels = 3;
}

function is_pjax()
{
    return (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true');
}