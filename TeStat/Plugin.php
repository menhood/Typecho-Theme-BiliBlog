<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 浏览数、喜欢数统计插件
 * 
 * @package TeStat
 * @author 绛木子
 * @version 1.1
 * @link http://lixianhua.com
 */
class TeStat_Plugin implements Typecho_Plugin_Interface
{
	public static $info = array();
	public static $mem = array();
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();
        // contents 表中若无 viewsNum 字段则添加
        if (!array_key_exists('viewsNum', $db->fetchRow($db->select()->from('table.contents'))))
            $db->query('ALTER TABLE `'. $prefix .'contents` ADD `viewsNum` INT(10) DEFAULT 0;');
		// contents 表中若无 likesNum 字段则添加
        if (!array_key_exists('likesNum', $db->fetchRow($db->select()->from('table.contents'))))
            $db->query('ALTER TABLE `'. $prefix .'contents` ADD `likesNum` INT(10) DEFAULT 0;');
        //增加浏览数
        Typecho_Plugin::factory('Widget_Archive')->singleHandle = array('TeStat_Plugin', 'viewCounter');
        //把新增的字段添加到查询中
        Typecho_Plugin::factory('Widget_Archive')->select = array('TeStat_Plugin', 'selectHandle');
		//添加动作
		Helper::addAction('likes', 'TeStat_Action');
		
		Typecho_Plugin::factory('Widget_Archive')->header = array('TeStat_Plugin','insertCss');
		Typecho_Plugin::factory('Widget_Archive')->footer = array('TeStat_Plugin','insertJs');
		
		Typecho_Plugin::factory('index.php')->begin = array('TeStat_Plugin', 'setBegin');
        Typecho_Plugin::factory('index.php')->end = array('TeStat_Plugin', 'setEnd');
		
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
	{
		Helper::removeAction('likes');
		
        $delFields = Typecho_Widget::widget('Widget_Options')->plugin('TeStat')->delFields;
        if($delFields){
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $db->query('ALTER TABLE `'. $prefix .'contents` DROP `viewsNum`;');
			$db->query('ALTER TABLE `'. $prefix .'contents` DROP `likesNum`;');
        }
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
	{	
		$delFields = new Typecho_Widget_Helper_Form_Element_Radio('delFields', 
            array(0=>_t('保留数据'),1=>_t('删除数据'),), '0', _t('卸载设置'),_t('卸载插件后数据是否保留'));
        $form->addInput($delFields);
		$allow_stat = new Typecho_Widget_Helper_Form_Element_Radio('allow_stat', 
            array(0=>_t('关闭'),1=>_t('开启'),), '1', _t('统计运行信息'),_t('是否开启运行信息统计'));
        $form->addInput($allow_stat);
		$allow_stat_mem = new Typecho_Widget_Helper_Form_Element_Radio('allow_stat_mem', 
            array(0=>_t('关闭'),1=>_t('开启'),), '1', _t('统计内存开销'),_t('是否开启内存开销统计'));
        $form->addInput($allow_stat_mem);
	}
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
	//记录开始执行的参数
	public static function setBegin(){
		$options = Typecho_Widget::widget('Widget_Options')->plugin('TeStat');
		
		if(!$options->allow_stat) return;
		
		self::$info['begin'] = microtime(TRUE);
		
		if($options->allow_stat_mem)
			self::$mem['begin'] =  memory_get_usage();
	}
	//记录执行结束的参数
	public static function setEnd(){
		$options = Typecho_Widget::widget('Widget_Options')->plugin('TeStat');
		
		if(!$options->allow_stat) return;
		
		if(isset(self::$info['end'])) return;
		
		self::$info['end'] = microtime(TRUE);
		
		if($options->allow_stat_mem)
			self::$mem['end'] =  memory_get_usage();
		
	}
	//显示记录的各种统计项
	public static function runtime($format='吞吐率:{rate},运行时间:{runtime},内存开销:{mem},加载文件:{files}'){
		$options = Typecho_Widget::widget('Widget_Options');
		if(!isset($options->plugins['activated']['TeStat'])) return;

		$options = $options->plugin('TeStat');
		if(!$options->allow_stat) return;
		
		if(isset(self::$info['begin']) && !isset(self::$info['end'])){
			self::setEnd();
		}
		$stat = array(
			'runtime'=>'未统计',
			'mem'=>'未统计',
			'files'=>count(get_included_files()),
			'rate'=>'未统计',
		);
		
		if(isset(self::$info['begin']) && isset(self::$info['end'])){
			$stat['runtime'] = number_format(self::$info['end']-self::$info['begin'],4).' s';
			$stat['rate'] = number_format(1/(self::$info['end']-self::$info['begin']),2).' req/s';
		}
		if(isset(self::$mem['begin']) && isset(self::$mem['end'])){
			$stat['mem'] = number_format((self::$mem['end']-self::$mem['begin'])/1024).' kb';
		}
		echo str_replace(array('{runtime}','{mem}','{files}','{rate}'),$stat,$format);
	}
    /**
     * 增加浏览量
     * @params Widget_Archive   $archive
     * @return void
     */
    public static function viewCounter($archive){
        if($archive->is('single')){
            $cid = $archive->cid;
            $views = Typecho_Cookie::get('__post_views');
            if(empty($views)){
                $views = array();
            }else{
                $views = explode(',', $views);
            }
            if(!in_array($cid,$views)){
                $db = Typecho_Db::get();
                $db->query($db->update('table.contents')->rows(array('viewsNum' => (int)$archive->viewsNum+1))->where('cid = ?', $cid));
                array_push($views, $cid);
                $views = implode(',', $views);
                Typecho_Cookie::set('__post_views', $views); //记录查看cookie
            }
        }
    }
	public static function insertCss($header,$widget){
		$action = Typecho_Common::url('/action/',Helper::options()->index);
		echo '<style type="text/css">.testat-dialog{position:fixed;top:100px;left:50%;padding:10px;background-color:#fff;display:none;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;z-index:1024;}
.testat-dialog.error{background-color:#f40;color:#fff;}
.testat-dialog.success{background-color:#24AA42;color:#fff;}</style><script type="text/javascript">window.action="'.$action.'";</script>';
	}
	public static function insertJs($widget){
		$script = <<<EOT
<script type="text/javascript">
$(function(){
	$('.btn-like').click(function(e){
		e.stopPropagation();
		e.preventDefault();
		var that = $(this),num = $(this).data('num'), cid = $(this).data('cid'),numEl = that.find('.post-likes-num');
		if(cid===undefined) return false;
		$.get(window.action+'likes?cid='+cid).success(function(rs){
			if(rs.status==1){
				if(numEl.length>0){
					numEl.text(num+1);
				}
				testatAlert(rs.msg===undefined ? '已成功为该文章点赞!' : rs.msg);
			}else{
				testatAlert(rs.msg===undefined ? '操作出错!' : rs.msg,'err');
			}
		});
	});
});
function testatAlert(msg,type,time){
	type = type === undefined ? 'success' : 'error';
	time = time === undefined ? (type=='success' ? 1500 : 3000) : time;
	var html = '<div class="testat-dialog '+type+'">'+msg+'</div>';
	$(html).appendTo($('body')).fadeIn(300,function(){
		setTimeout(function(){
			$('body > .testat-dialog').remove();
		},time);
	});
}
</script>
EOT;
		echo $script;
	}
    //cleanAttribute('fields')清除查询字段，select * 
    public static function selectHandle($archive){
        $user = Typecho_Widget::widget('Widget_User');
		if ('post' == $archive->parameter->type || 'page' == $archive->parameter->type) {
            if ($user->hasLogin()) {
                $select = $archive->select()->where('table.contents.status = ? OR table.contents.status = ? OR
                        (table.contents.status = ? AND table.contents.authorId = ?)',
                        'publish', 'hidden', 'private', $user->uid);
            } else {
                $select = $archive->select()->where('table.contents.status = ? OR table.contents.status = ?',
                        'publish', 'hidden');
            }
        } else {
            if ($user->hasLogin()) {
                $select = $archive->select()->where('table.contents.status = ? OR
                        (table.contents.status = ? AND table.contents.authorId = ?)', 'publish', 'private', $user->uid);
            } else {
                $select = $archive->select()->where('table.contents.status = ?', 'publish');
            }
        }
        $select->where('table.contents.created < ?', Typecho_Date::gmtTime());
        $select->cleanAttribute('fields');
        return $select;
	}
}