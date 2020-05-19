<?php

/**
 * BiliBlog
 *
 * @package biliblog
 * @author Menhood
 * @version 2.0 Alpha
 * @link https://blog.menhood.wang/archives/BiliBlog.html
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>

<?php if (!$this->request->isAjax()): ?>
<?php $this->need('header.php');
?>

    <!--文章主体-->
    <article class="index-post">
        <?php endif;
        //ajax判断结束 ?>
        <?php $index = 0;
        ?>
        <?php while ($this->next()) : ?>
        <?php $index++;
        ?>
        <div class="index-card load-a" style="margin-top: 8px;animation-delay:<?php echo 0.2*$index;
            ?>s;">
            <a class="user-head c-pointer" href="<?php $this->permalink() ?>" style="background-image: url(&quot;<?php ($this->options->userboxhead()) ?>&quot;); border-radius: 50%;">
                <!--头像图标--><i class="verify-icon verify-company"></i>
            </a>
            <div class="main-content" style="padding-bottom: 0px;">
                <div class="user-name fs-16 ls-0 d-i-block">
                    <a href="<?php $this->author->permalink();
                        ?>" class="c-pointer"><?php $this->author();
                        ?></a>
                </div>
                <div class="time fs-12 ls-0 tc-slate">
                    <?php $this->date('Y年m月d日');
                    ?><span data-v-230fe746=""></span>
                </div>
                <div class="index-card-content">
                    <div class=" description" style="<?php if (!$this->fields->customtext && !$this->tags) { echo "display:none;";
                    }
                        ?>">
                        <div class="content">
                            <div class="content-full">
                                <div class="tags">
                                    <?php $this->tags('，', true, '');
                                    ?>
                                </div>
                                <?php $this->fields->custom_text();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="original-card-content">
                            <div class="article-container">
                                <a href="<?php $this->permalink() ?>">
                                    <div>
                                        <div class="images-area">
                                            <img src="<?php if ($this->fields->thumb) { $this->fields->thumb();
                                            } else { echo "https://i.loli.net/2020/03/29/V2zU5uh6goiw9kc.gif";
                                            }
                                            ?>" class="card-1">
                                        </div>
                                        <div class="text-area">
                                            <div class="title">
                                                <?php $this->sticky();
                                                $this->title() ?>
                                            </div>
                                            <div class="content">
                                                <?php $this->excerpt(300, '....');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="button-bar tc-slate">
                    <div class="single-button">
                        <span class="text-bar"><i class="bp-svg-icon single-icon views"></i>
                            <span class="text-offset">
                                <?= get_post_view($this);?>
                            </span></span>
                    </div>
                    <div class="single-button c-pointer" id="comment_btn">
                        <a href="<?php $this->permalink() ?>#comments">
                        <span class="text-bar"><i class="bp-svg-icon single-icon comment"></i>
                            <span class="text-offset">
                                <?php $this->commentsNum('%d');
                                ?>
                            </span></span>
                        </a>
                    </div>
                    <div class="single-button c-pointer like_btns" data-cid="<?php $this->cid();?>" data-num="<?php likesNum();?>" >
                        <span class="text-bar"><i class="custom-like-icon zan" id="like_i_<?php $this->cid();?>"></i>
                            <span class="text-offset" id="like_s_<?php $this->cid();?>">
                                <?php likesNum();?>
                            </span></span>
                    </div>
                </div>
            </div>

        </div>
        <?php endwhile;
        ?>
        <?php if(!$this->next()){exit(header('HTTP/1.1 204 No Content'));}?>
<?php if (!$this->request->isAjax()): ?>

        <?php //$this->pageNav('上一页', '下一页', '2', '……'); ?>
    </article>
    <div class="index_poat_loadmore" id="spinner" style="display:none;">
        <span class="index_loadmore__tips"><i class="index_post_loading"></i>正在加载</span>
    </div>
    <div class="index_post_loadmore index_loadmore_line" id="nomore" style="display:none;">
        <span class="index_loadmore__tips">到底了</span>
    </div>
    <button style="display:none;" id="blog_load_more">load_more</button>
    <script type="text/javascript">
        var SITE = <?php site_data();
        ?>; //页面信息
    </script>
    </div><!--end index_post_list-->

    <?php if ($this->options->sidebar_stat == "r" || $this->options->sidebar_stat == "lr") : ?>
    <?php $this->need('sidebar-r.php');
    ?>
    <?php endif;
    //右侧栏开关判断结束 ?>
</div>
<!-- end #main-->
</div><!-- container end-->
<!--TO-TOP-->
<p id="to-top" class="back-top">
    <a href="#top"><span></span></a>
</p>
<?php endif;
//加载更多以及右侧栏 ajax判断结束 ?>
<?php if (!$this->request->isAjax()): ?>
<?php $this->need('footer.php');
?>
<?php endif;
//底部 ajax判断结束 ?>