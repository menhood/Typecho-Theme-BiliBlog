<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!--右侧栏-->                   <?php if ($this->options->lanshu==3):?>
                                <div class="col-md-3 column" style="padding:0" id="sidebar-r">
                                <?php endif;?>    
                                    <!--右侧栏1-->
                                    <div class="row clearfix load-a" style="animation-delay:0.2s" id="Post_Recent">
                                        <div class="col-xs-12 col-md-12 col-lg-12 column">
                                            <div class="card" >
                                                <p class="card-title">最近文章</p>
                                                <div class="card-more"> <a href="<?php $this->options->siteUrl(); ?>index.php/timeline.html" target="_blank" class="card-more-a a">。。。</a>

                                                </div>
                                                <div class="card-content"> 
                                                <?php $this->widget('Widget_Contents_Post_Recent')->to($post); ?>
                                                <?php while($post->next()): ?>
                                                <a href="<?php $post->permalink(); ?>" title="<?php $post->title(); ?>" class="a">
                                                <li><?php $post->title(25, '…'); ?></li>
                                                </a>
                                                <?php endwhile; ?>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--右侧栏2-->
                                    <div class="row clearfix load-a" style="animation-delay:0.4s" id="Comments_Recent">
                                        <div class="col-xs-12 col-md-12 col-lg-12 column">
                                            <div class="card">
                                                <p class="card-title">最近评论</p>
                                                <div class="card-more"> <a href="<?php $this->options->siteUrl(); ?>index.php/about.html" target="_blank" class="card-more-a a">...</a>

                                                </div>
                                                <div class="card-content" id="zjpl"> 
                                                <?php $this->widget('Widget_Comments_Recent','ignoreAuthor=true')->parse('<a href="{permalink}" class="a"><li style="max-width: 280px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{text}</li></a>'); ?>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php if ($this->options->lanshu==3):?>
                                </div>
                                <?php endif;?>
<!-- end #sidebar -->
