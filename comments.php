<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php function threadedComments($comments, $options) {
    $commentClass = '';
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    ?>
    <li id="li-<?php $comments->theId(); ?>" class="comment-body<?php
    if ($comments->levels > 0) {
        echo ' comment-child';
        $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
    } else {
        echo ' comment-parent';
    }
    $comments->alt(' comment-odd', ' comment-even');
    echo $commentClass;
    ?>">
    	<div class="row clearfix">
		<div class="col-md-12 column comment-item" id="<?php $comments->theId(); ?>" style="padding-left: 0;">
			<div class="row clearfix">
				<div class="col-md-2 column">
				    <?php $comments->gravatar('40', ''); ?>
				</div>
				<div class="col-md-10 column">
					<div class="row clearfix">
						<div class="col-md-12 column ">
						    <span class="fn">
                            <?php $comments->author(); ?>
                            <?php if ($comments->authorId) {
                                if ($comments->authorId == $comments->ownerId) {
                                    echo "<span class='author-after-text'>UP</span>";
                                }?>
                            <?php }?>
                            </span>
						    
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-md-12 column comment-content">
						   <?php $comments->content(); ?> 
						</div>
					</div>	    
					<div class="row clearfix">
						<div class="col-md-8 column">
                        <div class="comment-meta">
                           <a href="<?php $comments->permalink(); ?>"><span class="comment-fnum">#&nbsp;<?php $comments->sequence(); ?>&nbsp;</span><?php $comments->date('Y-m-d H:i'); ?></a>
                        </div>
						</div>
						<div class="col-md-4 column">
						    <span class="comment-reply"><?php $comments->reply(); ?></span>
						</div>
					</div>
				</div>
			</div>
			<?php if ($comments->children) { ?>
            <div class="comment-children">
                <?php $comments->threadedComments($options); ?>
            </div>
        <?php } ?>
		</div>
	</div>

        
    </li>
<?php } ?>

<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
	<h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>
    
    <?php $comments->listComments(); ?>

    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    
    <?php endif; ?>
    <div class="row clearfix">
		<div class="col-md-12 column">
    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
        <div class="cancel-comment-reply">
        <?php $comments->cancelReply(); ?>
        </div>
    
    	<!--<h3 id="response"><?php _e('添加新评论'); ?></h3>-->
    	<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
            <?php if($this->user->hasLogin()): ?>
    		<p><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
            <?php else: ?>
    		<li>
                <label for="author" class="required"><?php _e('称呼'); ?></label>
    			<input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
    		</li>
    		<li>
                <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('Email'); ?></label>
    			<input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
    		</li>
    		<li>
    		    <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
    		    <input type="url" name="url" id="url" class="text text-url" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
    		</li>
            <?php endif; ?>
            <br>
                <textarea rows="8" cols="50" name="text" id="textarea" class="textarea" required ><?php $this->remember('text'); ?></textarea>
                <button type="submit" class="submit"><?php _e('提交评论'); ?></button>
            <?php Smilies_Plugin::output(); ?>    
    	</form>
    </div>
    <?php else: ?>
    <h3><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
        </div>
    </div>
</div>
