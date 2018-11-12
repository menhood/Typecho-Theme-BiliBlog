<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<?php function threadedComments($comments, $options) {
    $commentClass = '';
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    $depth = $comments->levels +1;
    ?>
    <li id="li-<?php $comments->theId();
        ?>" class="comment-body<?php
        if ($depth > 1 && $depth < 3) {
            echo ' comment-child';
            $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
        } elseif ( $depth > 2 ) {
            echo ' comment-child2';
            $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
        } else {
            echo ' comment-parent';
        }
        $comments->alt(' comment-odd', ' comment-even');
        echo $commentClass;
        ?>">
        <div class="row clearfix">
            <div class="col-md-12 column comment-item" id="<?php $comments->theId();?>" style="padding-left: ;">
                <div class="row clearfix" >
                    <div class="col-md-2 column" style="margin-top:8px" >
                        <?php $comments->gravatar('40', 'https://i.loli.net/2018/10/28/5bd55579d2d72.png');?>
                    </div>
                    <div class="col-md-10 column">
                        <div class="row clearfix">
                            <div class="col-md-12 column ">
                                <span class="fn" style="<?php if ($depth == 1){echo 'border-top: 1px solid #e5e9ef;';}?>">
                                    <?php $comments->author();?>
                                    <?php if ($comments->authorId) {
                                        if ($comments->authorId == $comments->ownerId) {
                                            echo "<span class='author-after-text'>UP</span>";
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>
                                </span>

                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-12 column comment-content">
                                <?php $comments->content();
                                ?>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-12 column">
                                <div class="comment-meta">
                                    <a href="<?php $comments->permalink();?>">
                                        <span class="comment-fnum">#&nbsp;<?php $comments->sequence();?>&nbsp;</span>
                                        <?php $comments->date('Y-m-d H:i');?>
                                    </a>
                                    <span class="comment-reply"><?php $comments->reply();?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($comments->children) {
                    ?>
                    <div class="comment-children">
                        <?php $comments->threadedComments($options);
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>


    </li>
    <?php
}
?>

<div id="comments">
    <?php $this->comments()->to($comments);
    ?>
    <?php if ($comments->have()): ?>
    <h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论'));
        ?></h3>

    <?php $comments->listComments();
    ?>

    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;');
    ?>

    <?php endif;
    ?>

    <div class="row clearfix">
        <div class="col-md-12 column">
            <?php if ($this->allow('comment')): ?>
            <div id="<?php $this->respondId();
                ?>" class="respond">
                <div class="cancel-comment-reply">
                    <?php $comments->cancelReply();
                    ?>
                </div>

                <!--<h3 id="response"><?php _e('添加新评论');
                ?></h3>-->
                <?php if ($this->user->hasLogin()): ?>
                <p>
                    <?php _e('登录身份: ');
                    ?><a href="<?php $this->options->profileUrl();
                        ?>"><?php $this->user->screenName();
                        ?></a>. <a href="<?php $this->options->logoutUrl();
                        ?>" title="Logout"><?php _e('退出');
                        ?> &raquo;</a>
                </p>
                <?php else : ?>

                <div class="row clearfix">
                    <form method="post" action="<?php $this->commentUrl() ?>">
                        <div class="col-md-2 column">
                            <img src="<?php if ($this->remember('mail',true)): ?><?php _e('https://gravatar.loli.net/avatar/'.md5($this->remember('mail',true)))?><?php else :_e('https://i.loli.net/2018/10/28/5bd55579d2d72.png')?><?php endif;
                            ?>" id="chead" style="float: right;position: relative;width: 48px;height: 48px;border-radius: 50%;margin-left: 8px;">
                        </div>
                        <div class="col-md-10 column">
                            <div class="row clearfix">
                                <div class="col-md-3 column" style="padding-left:10px;margin-bottom:2px">
                                    <div class="bs-example bs-example-form" role="form">
                                        <div class="input-group">
                                            <label for="author">称呼</label>
                                            <!--<span class="input-group-addon"><?php _e('称呼');
                                                ?></span>-->
                                            <input type="text" class="form-control text" placeholder="昵称" name="author" id="author" value="<?php $this->remember('author');
                                            ?>" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3 column" style="padding-left:10px;margin-bottom:2px">
                                    <div class="bs-example bs-example-form" role="form">
                                        <div class="input-group">
                                            <label for="mail">邮箱</label>
                                            <!--<span class="input-group-addon<?php if ($this->options->commentsRequireMail): ?> required<?php endif;
                                                ?>"><?php _e('Email');
                                                ?></span>-->
                                            <input type="text" class="form-control text" placeholder="邮箱地址" name="mail" id="mail" value="<?php $this->remember('mail');
                                            ?>" <?php if ($this->options->commentsRequireMail): ?> required<?php endif;
                                            ?> />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 column" style="padding-left:10px;margin-bottom:2px">
                                    <div class="bs-example bs-example-form" role="form">
                                        <div class="input-group">
                                            <label for="url">网站</label>
                                            <!--<span class="input-group-addon"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif;
                                                ?>><?php _e('网站');
                                                ?></span>-->
                                            <input type="text" class="form-control text text-url" placeholder="<?php _e('http://');
                                            ?>" name="url" id="url" value="<?php $this->remember('url');
                                            ?>" <?php if ($this->options->commentsRequireURL): ?> required<?php endif;
                                            ?> />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif;
                            ?>
                            <?php if ($this->user->hasLogin()): ?>
                            <form method="post" action="<?php $this->commentUrl() ?>">
                                <?php endif;
                                ?>
                                <div class="row clearfix"<?php if ($this->user->hasLogin()): ?> style="padding-left:8px"<?php endif;?>>
                                    <div class="col-md-9 column" style="padding-left:8px">
                                        <textarea rows="8" cols="50" name="text" id="textarea" class="textarea" required><?php $this->remember('text');
                                            ?></textarea>
                                    </div>
                                    <div class="col-md-1 column" style="padding-left:8px">
                                        <button type="submit" class="submit"><?php _e('提交评论');
                                            ?></button>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-md-1 column">
                                        <?php Smilies_Plugin::output();
                                        ?>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                    <?php else : ?>
                    <h3><?php _e('评论已关闭');
                        ?></h3>
                    <?php endif;
                    ?>
                </div>
            </div>


        </div>
</div>