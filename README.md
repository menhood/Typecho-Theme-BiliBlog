# Typecho-Theme-Biliblog
> 🍻 Typecho Bilibili配色风格主题

![](https://img.shields.io/badge/Typecho-1.1-orange.svg)
![](https://img.shields.io/badge/Biliblog-2.0_Alpha-blue.svg)

![](https://i.loli.net/2020/05/22/ez8PsF4wdtuHWYo.png)

> 在线示例：http://biliblog.menhood.wang/

## BiliBlog食用指南
没有做系统规划，补丁很多，凑合用的状态见谅。

具体功能请看主题设置部分，没有的选项可以[点此](https://blog.menhood.wang/archives/BiliBlog.html)
查看详细及反馈

**2.0版本去除了pjax，也去除了移动端样式**

现在处于魔改阶段，各种bug都会有，😆

### 安装
上传至主题目录 `/usr/themes/` 然后文件夹改名为 `biliblog` 即可

### 自定义
#### 自定义首页
* 修改头像、个人信息部分在主题设置中
* 站点描述、关键词也在主题设置中

#### 自定义页面(<small>必备，不然某些链接会报404</small>)
* 归档(时间线)页面：新建页面，名称为`timeline`，自定义模板选择`Template Page of timeline Archives`
* 搜索页面：新建页面，名称为`search`，自定义模板选择`Template Page of Search`
* 友链页面：新建页面，名称为`links`，自定义模板选择`Template Page of Links`,根据示例修改数组内容即可

#### 自定义字段
* `thumb`:封面地址，需要带`http://`或`https://`
* `customtext`:显示在首页tags下面的内容，支持html代码

#### 播放器
##### APlayer播放器
直接写在页面内即可，代码：

```html
!!!
    <!-- MetingJS start -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.css">
    <div class="aplayer" data-id="100845969" data-server="netease" data-type="playlist" data-autoplay="false" data-volume="0.6" id="fixedap"></div>
    <script src="https://cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/meting/dist/Meting.min.js"></script>
    <script>
    var meting_api='https://api.fczbl.vip/163/?server=netease&type=playlist&id=100845969';
    </script>
    <!-- MetingJS end -->
!!!
```
代码中的`data-id`，即`100845969`为网易云歌单id，修改替换两处即可
##### DPlayer播放器
直接写在页面内即可，代码：

```html

!!!
<link href="https://cdnjs.loli.net/ajax/libs/dplayer/1.22.2/DPlayer.min.css" rel="stylesheet">
<div id="dplayer"></div>
<script src="https://cdnjs.loli.net/ajax/libs/dplayer/1.22.2/DPlayer.min.js"></script>
<script>
const dp = new DPlayer({
    container: document.getElementById('dplayer'),
    loop:true,
    video: {
        url: 'https://ddns.menhood.wang:2233/files/%E5%8A%A8%E6%BC%AB/VioletEvergarden/%E3%82%A2%E3%83%8B%E3%83%A1%E3%80%8E%E3%83%B4%E3%82%A1%E3%82%A4%E3%82%AA%E3%83%AC%E3%83%83%E3%83%88%E3%83%BB%E3%82%A8%E3%83%B4%E3%82%A1%E3%83%BC%E3%82%AC%E3%83%BC%E3%83%87%E3%83%B3%E3%80%8FPV%E7%AC%AC2%E5%BC%BE.mp4'
    }
});
</script>
!!!

```
以上代码较为简略，具体参数可以去[DPlayer文档](http://dplayer.js.org/#/zh-Hans/?id=%E5%8F%82%E6%95%B0)查阅
#### 统计代码
自行在`header.php`或`footer.php`添加

### 注意
模板禁用了博客程序的`开启反垃圾保护`选项，如需评论过滤请安装其他评论管理插件

还有很多坑，如果遇到请[留言](https://blog.menhood.wang/archives/BiliBlog.html#comments)与我联系，我有时间会帮忙解决的（前提是没超出我的能力范围，菜的抠脚 哈哈）

### 感谢
* [Bilibili](https://t.bilibili.com)
* [DIYgod](https://github.com/DIYgod)
* [APlayer](http://aplayer.js.org)
* [DPlayer](http://dplayer.js.org)
* [MetingJS](https://github.com/metowolf/MetingJS)
* [Baidu](https://www.baidu.com)
* [狗子的API](https://api.fczbl.vip/)
* 百度访问到的大佬们...

## Author

**biliblog** © [Menhood](https://github.com/menhood), Released under the [MIT](./LICENSE) License.<br>

> Blog [@Menhood](https://menhood.wang) · GitHub [@Menhood](https://github.com/Menhood) · Twitter [@Menhoodt](https://twitter.com/menhoodt) · Telegram [@Menhood](https://t.me/Menhood)