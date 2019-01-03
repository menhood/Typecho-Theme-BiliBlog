# Typecho-Theme-Biliblog [已迁移到Coding](https://dev.tencent.com/u/Menhood/p/Typecho-Theme-BiliBlog/git)
> 🍻 Typecho Bilibili配色风格主题

![](https://img.shields.io/badge/Typecho-1.1-orange.svg)
![](https://img.shields.io/badge/Biliblog-1.0.3-blue.svg)

![](https://i.loli.net/2019/01/03/5c2d6ecfd0dd3.jpg)

> 在线示例：https://blog.menhood.wang/

## BiliBlog食用指南

⚠[已迁移到Coding](https://dev.tencent.com/u/Menhood/p/Typecho-Theme-BiliBlog/git)

不大会用git，图省事，所以**GitHub停止更新**

没有做系统规划，补丁很多，凑合用的状态见谅。

具体功能请看主题设置部分，没有的选项可以[点此](https://blog.menhood.wang/archives/BiliBlog.html)

查看详细及反馈

### 安装
上传至主题目录 `/usr/themes/` 然后文件夹改名为 `biliblog` 即可

部分功能需要插件支持

### 自定义
#### 自定义首页
* 修改头像、个人信息部分在主题设置中
* 站点描述、关键词也在主题设置中
* 主页栏数在主题设置中，支持1、2、3栏

#### 自定义页面
* 归档(时间线)页面：新建页面，名称为`Timeline`，自定义模板选择`Template Page of Timeline Archives`
* 搜索页面：新建页面，名称为`search`，自定义模板选择`Template Page of Search`
* 友链页面：新建页面，名称为`Friends`，自定义模板选择`Template Page of Links`,根据示例修改数组内容即可

#### 自定义字段
* `thumb`:封面地址，需要带`http://`或`https://`
* `customtext`:显示在首页tags下面的内容，支持html代码
#### 其他
* TOC目录默认是开启的，如果想禁用请在`index.php`中把样式改为"display:none"
* 右上角的齿轮栏填入相应内容可加载背景图片和歌单，背景图默认地址在`header.php`第133行修改网址即可，网易云可在后台设置
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
        url: 'https://menhood.320.io/files/%E5%8A%A8%E6%BC%AB/VioletEvergarden/%E3%82%A2%E3%83%8B%E3%83%A1%E3%80%8E%E3%83%B4%E3%82%A1%E3%82%A4%E3%82%AA%E3%83%AC%E3%83%83%E3%83%88%E3%83%BB%E3%82%A8%E3%83%B4%E3%82%A1%E3%83%BC%E3%82%AC%E3%83%BC%E3%83%87%E3%83%B3%E3%80%8FPV%E7%AC%AC2%E5%BC%BE.mp4'
    }
});
</script>
!!!

```
以上代码较为简略，具体参数可以去[DPlayer文档](http://dplayer.js.org/#/zh-Hans/?id=%E5%8F%82%E6%95%B0)查阅
#### 统计代码
自行在`header.php`或`footer.php`添加

### 插件

* TeStat（点赞）
* Smilies（表情）

直接把文件夹放到插件目录然后开启

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

> Blog [@Menhood](https://menhood.wang) · GitHub [@Menhood](https://github.com/Menhood) · Twitter [@Menhoodt](https://twitter.com/menhoodt) · Telegram Channel [@Menhood](https://t.me/Menhood)
