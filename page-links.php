<?php
/**
* Template Page of Links
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php $this->need('header.php'); ?>
<?php $linksarray=array(
    array(
        "name"=>"狗子",
        "img"=>"https://cdn.v2ex.com/gravatar/5e6892e999ca8c85a358d21164167f38",
        "url"=>"https://moedog.org/",
        "desc"=>"狗窝"
        ),
    array(
        "name"=>"Fghrsh",
        "img"=>"https://cdn.v2ex.com/gravatar/0c5d77513a08b8c3e38336859b53b027",
        "url"=>"https://www.fghrsh.net/",
        "desc"=>"开箱大佬"
        ),
    array(
        "name"=>"陌路寒暄",
        "img"=>"https://cdn.v2ex.com/gravatar/975c100f3def27bf46c78f5e971c8ac6",
        "url"=>"https://www.imlhx.com/",
        "desc"=>"这让人揪心的代码"
        ),
    array(
        "name"=>"echisan",
        "img"=>"https://img.menhood.wang/v2/i/2019/06/09/r6zy0j.png",
        "url"=>"https://echisan.github.io/",
        "desc"=>"春宵苦短，少年前进吧"
        ),
    array(
        "name"=>"kira",
        "img"=>"https://cdn.v2ex.com/gravatar/7996926e35cfd3000ef154c17c9ce8fa",
        "url"=>"https://moekira.com/",
        "desc"=>"咕咕咕"
        ),
    array(
        "name"=>"DIYgod",
        "img"=>"https://img.menhood.wang/v2/i/2019/06/09/r4l2aw.png",
        "url"=>"https://diygod.me/",
        "desc"=>"网红大佬;Bilibili大佬;女装大佬;"
        ),
    array(
        "name"=>"极的箱子",
        "img"=>"https://img.menhood.wang/v2/i/2019/06/09/r4l2gx.jpg",
        "url"=>"http://www.ji2.xyz/",
        "desc"=>"黄盘掌控者"
        ),
    array(
        "name"=>"Gazzz",
        "img"=>"https://cdn.v2ex.com/gravatar/587d8de0d726e93286aac6001c246519",
        "url"=>"http://www.gazyip.cn/",
        "desc"=>"瞳神铁粉 233"
        ),
    array(
        "name"=>"Rinvay",
        "img"=>"https://cdn.v2ex.com/gravatar/0e17d3ec8d6fbbfce870d97b943ceef3",
        "url"=>"https://www.rinvay.cc/",
        "desc"=>"运维大佬；重庆汉子"
        ),
    array(
        "name"=>"Darker",
        "img"=>"https://img.menhood.wang/v2/i/2019/06/09/r4kxpu.png",
        "url"=>"https://darker.me/",
        "desc"=>"？？？"
        ),
    array(
        "name"=>"Macrazd S",
        "img"=>"https://img.menhood.wang/v2/i/2019/06/09/r4l1jz.jpg",
        "url"=>"https://macrazds.cn/",
        "desc"=>"<ruby>复读基<rt>cv牌</rt></ruby>"
        ),
    array(
        "name"=>"Plenty More",
        "img"=>"https://img.menhood.wang/v2/i/2019/06/09/r4l0sr.jpg",
        "url"=>"https://plentymore.github.io/",
        "desc"=>"后端<ruby>大<rt>Darker</rt></ruby>佬"
        ),
    array(
        "name"=>"可乐加点冰",
        "img"=>"https://wx2.sbimg.cn/2019/05/12/1533135041-hFrkZGsmWS.jpg",
        "url"=>"http://guhub.cn",
        "desc"=>"All for one,one for all."
        ),
    array(
        "name"=>"喵の窝",
        "img"=>"http://tyzual.com/favicon.ico?v=5.1.0",
        "url"=>"http://tyzual.com",
        "desc"=>"芬达的铲屎官;鹅厂高级吉祥物"
        ),
    array(
        "name"=>"Aloner",
        "img"=>"https://gravatar.loli.net/avatar/b013507eda0f9df7819925e18a920bb9",
        "url"=>"https://www.aloneblog.me/",
        "desc"=>"alone but not lonely"
        ),
    array(
        "name"=>"Menhood",
        "img"=>"https://gravatar.loli.net/avatar/17842af77c9727c64e6468ad6d9d3f96",
        "url"=>"https://www.menhood.wang/",
        "desc"=>"咸鱼主题作者"
        ),
   array(
        "name"=>"狗子",
        "img"=>"https://cdn.v2ex.com/gravatar/5e6892e999ca8c85a358d21164167f38",
        "url"=>"https://moedog.org/",
        "desc"=>"狗窝"
        )
    );
?>
<script>
    isindex = false;
    $(document).attr("title", "<?php $this->title() ?>");
    $("body").attr("style", "background:#fff");
</script>
<div class="container">
<div class="main-body">
<?php $this->need('sidebar-l.php');
?>
            <article class="mid-body" style="background-color:#fff;border-radius:8px;margin-top: 20px;min-height:380px" >
                <div class="links-box">
                <?php foreach($linksarray as $v){
echo <<<EOF
			                    <a href="{$v['url']}" target="_blank"  >
			                    <div class="links custom-links" id="{$v['name']}">
			                        <div class="links-head">
				                            <img src=" {$v['img']}" />
				                    </div>
				                    
				                    <div class="links-info" >
				                        <p class="links-title">{$v['name']}</p>
                                        <span class="links-desc">{$v['desc']}</span>
				                    </div>
				                    
				                </div>
				                </a>
EOF;
} ?>
                </div>
                <div style="clear:both"></div>
                <div class="post-content" itemprop="articleBody">
                    <?php $this->content(); ?>
                </div>
                <div style="max-width:660px;padding: 8px 8px 0px 8px;background-color:#fff;">    
                <?php $this->need('comments.php'); ?>
                </div>
            </article>  
            <?php $this->need('sidebar-r.php'); ?>
        </div>
    
</div>
<?php $this->need('footer.php'); ?>