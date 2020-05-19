<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<?php if ($this->allow('comment')): 
    $this->comments()->to($comments);//把this内容赋给comments变量
?>
<div id="<?php $this->respondId();;?>" class="respond">

<?php
if ($this->user->hasLogin())://判断登录开始
?>
<div class="comment-send no-login">
    <div class="user-face">
        <img class="user-head" src="<?php $this->options->userboxhead();
        ?>">
    </div>
    <div class="textarea-container">
        <form  method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
        <i class="ipt-arrow"></i>
        <textarea id="comment_textarea" cols="80" name="text" rows="5" placeholder="请自觉遵守互联网相关的政策法规，严禁发布色情、暴力、反动的言论。" class="ipt-txt"></textarea>
        <button type="button"  id="comment_submit_btn" class="comment-submit">发表评论</button>
        <button type="submit"  id="c_submit_btn" style="display:none;"></button>
        </form>
    </div>
        <div id="OwO" class="OwO " style="margin:3px 0 0 86px;"></div>
    <div class="cancel-comment-reply"><?php $comments->cancelReply('取消回复');?></div>
</div>
<?php endif;
//判断登录完成 ?>
<?php
if (!$this->user->hasLogin())://判断访客开始
?>
<div class="comment-send no-login">
    <div class="user-face">
        <img id="user-head" class="user-head" src="https://i.loli.net/2018/10/28/5bd55579d2d72.png">
    </div>
    <div class="textarea-container">
        <form  method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
            <input type="text" name="author" id="sync_author" class="text" style="display:none;" />
            <input type="email" name="mail" id="sync_mail" class="text" style="display:none;" />
            <input type="url" name="url" id="sync_url" class="text" style="display:none;" />
            <input type="hidden" name="_" value="<?php $security = $this->widget('Widget_Security');echo $security->getToken($this->request->getReferer())?>" />
        <div class="baffle-wrap">
            <div class="baffle">
                请先<span id="guest_login_btn" class="b-btn btn-open-mini-Login">登录</span>后发表评论 (・ω・)
            </div>
        </div>
        <i class="ipt-arrow"></i><textarea id="comment_textarea" cols="80" name="text" rows="5" placeholder="请自觉遵守互联网相关的政策法规，严禁发布色情、暴力、反动的言论。" class="ipt-txt"></textarea><button id="comment_submit_btn" type="button" class="comment-submit disabled" disabled="disabled">发表评论</button>
        <button type="submit"  id="c_submit_btn" style="display:none;"></button>
        </form>
    </div>
    <div id="OwO" class="OwO " style="margin:3px 0 0 86px;"></div>
    <div class="cancel-comment-reply"><?php $comments->cancelReply('取消回复');?></div>
</div>
<?php endif;
//判断访客完成 ?>
<link rel="stylesheet" href="<?php echo $this->options->rootUrl;?>/usr/themes/biliblog/static/css/OwO.min.css">
<script src="<?php echo $this->options->rootUrl;?>/usr/themes/biliblog/static/js/OwO.min.js" type="text/javascript"></script>
<script>
    var OwO = new OwO({
        logo: '<i class="face"></i>表情',
        container: document.getElementById('OwO'),
        target: document.getElementById('comment_textarea'),
        api: "<?php echo $this->options->rootUrl;
        ?>/usr/themes/biliblog/static/js/OwO.json",
        position: 'up',
        width: '100%',
        maxHeight: '250px'
    });
</script>

<?php else : ?>
<h3><?php _e('评论已关闭');
    ?></h3>
<?php endif;
?>
</div>  
<?php if ($comments->have()): ?>
<h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论'));?></h3>

<?php $comments->listComments();
?>

<?php $comments->pageNav(' 上一页', '下一页 ');?>

<?php endif;
?>
<?php function threadedComments($comments, $options) {
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    $depth = $comments->levels +1;//实际层数
    $theId =  $comments->theId;
?>

<li id="li-<?php $comments->theId();?>" class="comment-body<?php
        if ($depth == 2) {echo ' comment-child';$comments->levelsAlt(' comment-level-2', ' comment-level-even');
        } else {echo ' comment-parent';}
        $comments->alt(' comment-odd', ' comment-even');
        echo $commentClass;
        ?>">
    
    <div  class="list-item reply-wrap ">
        
        <?php if ($depth == 1) { ?>
        <div class="user-face">
            <a href="<?php $comments->permalink();?>" target="_blank" >
               <?php $comments->gravatar('40', 'https://i.loli.net/2018/10/28/5bd55579d2d72.png');?>
            </a>
        </div>
        
        <?php }else{ ?>
        
        <a href="<?php $comments->permalink();?>" target="_blank" class="reply-face" <?php if(stristr($comments->content,"<img")){ echo 'style="top: 32px;"';}?>>
               <?php $comments->gravatar('40', 'https://i.loli.net/2018/10/28/5bd55579d2d72.png');?>
            </a> 
        
        <?php } ?>
        
        <div id="<?php $comments->theId();?>" class="<?php if ($depth == 1 ):?>con<?php elseif($depth == 2):?>con-2 <?php else :?>reply-con<?php endif;?>">
            <div class="user">
                <a  href="<?php $comments->permalink();?>" target="_blank" class="name"><?php $comments->author();?></a>
                <a class="level-link" href="#" target="_blank">
                    <i class="level <?php if($comments->authorId == $comments->ownerId){echo "l9";}else{get_level($comments->mail);}?>"></i>
                </a>
            </div>
            <div class="text text-con">
                <?php /*echo "当前评论层数".$depth;*/get_comment_at($comments->coid);$comments->content();?>
            </div>
            <div class="info">
                <span class="time"><?php if ($depth == 1 ):?>#&nbsp;<?php $comments->sequence();?>&nbsp;<?php endif;?><?php echo timesince($comments->created);?></span>
                <span class="like " id="<?php echo $theId;?>_like" data-coid="<?php echo $comments->coid;?>" data-num="<?php likesNum($comments->coid);?>">
                    <i></i>
                    <span id="cmt_zan_num_<?php echo $comments->coid;?>"><?php likesNum($comments->coid);?></span>
                </span>
                <span class="reply btn-hover "><?php $comments->reply("回复");?></span>
            </div>
            
            <div class="paging-box"></div>
        </div>
        
        <?php if ($comments->children) { ?>
            <div class="reply-box" >
                <?php $comments->threadedComments($options);?>
            </div>
            <?php } //子回复层判断结束?>
    </div>
</li>


    <?php }?>