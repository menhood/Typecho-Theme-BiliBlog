/*
 * 定义全局参数
 */

var login_box_height = "",
_now_url = window.location.href,
login_url = "",
page = 1,
time_1 = 0,
srcollOld = 0,
srcollNow = 0,
scrollFun = false,
nocontent = false,
$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body'); //滚动加载用

/*
 * 监听事件
 */

//滚动
$(window).scroll(function() {
    //小屏幕下的导航条折叠
    if ($(window).width() < 768) {
        //点击导航链接之后，把导航选项折叠起来
        $(".navbar-toggle").click(function() {
            $("#navbar-collapse-1").collapse('hide');
        });
        //滚动屏幕时，把导航选项折叠起来
        $(window).scroll(function() {
            $("#navbar-collapse-1").collapse('hide');

        });
    }

    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();

    //滚动加载 一次一个请求
    var bot = 50; //bot是底部距离的高度
    if ((bot + $(window).scrollTop()) >= ($(document).height() - $(window).height())) {
        srcollNow = $(window).scrollTop();
        if (srcollNow >= srcollOld && !nocontent && isindex) {
            if (!scrollFun) {
                //第一次请求完成后才发第二次请求
                scrollFun = true;
                clearTimeout(time_1);
                time_1 = window.setTimeout(function() {
                    blog_load_more();
                }, 500);
            }
        }
        srcollOld = srcollNow;
    }

    var wt = $(window).scrollTop(),
        tw = $('.nav-mask').width(),
        dh = document.body.scrollHeight,
        wh = $(window).height();
    var width = tw / (dh - wh) * wt; //遮罩层宽度/（浏览器所有内容高度-窗口高度）*滚动高度
    $('.scrollgress').width(width);
});

//加载完成调用
$(function() {

    if ($(document).width() < 775) {
        $('#navbar-collapse-1').collapse("hide");
    }

    $('.post').scrollgress({
        height: '42px',
        color: '#00a1d6',
        success: function() {
            console.log('Scrollgress has been initiated.');
        }
    });

    //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
    $(function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 100) {
                $("#to-top").fadeIn(800);
                $(".right-side-bar").attr("class", "right-side-bar on");
            } else {
                $("#to-top").fadeOut(800);
                $(".right-side-bar").attr("class", "right-side-bar");
            }
        });

        //当点击跳转链接后，回到页面顶部位置

        $("#to-top,.to-top").click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 1000);
            return false;
        });
        $(".to-comment").click(function() {
            var _scrolltop = $('.comment-send').offset().top;
            $('body,html').animate({
                scrollTop: _scrolltop
            }, 1000);
            return false;
        });
    });

    //下滑显示导航
    $(function() {
        var nav = $(".nav-mask"); //得到导航对象
        var win = $(window); //得到窗口对象
        var sc = $(document); //得到document文档对象。
        win.scroll(function() {
            if (sc.scrollTop() >= 50) {
                nav.addClass("fixednav");
                $(".navTmp").fadeIn();
            } else {
                nav.removeClass("fixednav");
                $(".navTmp").fadeOut();
            }
        })
    });
    //检查访客信息是否填写
    if(hasLogin !== "1"){check_guest_info();}
    //加载文章目录
    loadTOC();
    //导航目录高亮
    tochl();
    //平滑滚动
    // phgd();
    
    //检查是否登录动画赋值
    if(hasLogin){login_box_height="0";}else{login_box_height="226px";}
});

//监听点击
$("#login-box-msk").click(function() {
    $(this).hide();
    login_box_animate();
    $("#login-box").hide("slow");
});
$("#closetoc_msk").click(function() {
    $(this).hide();
    $("#article-list-index").attr("class","show top");
});

//登录框
$("#login-a").click(function() {
    login_box_animate();
    $("#login-box-msk").toggle();
    $("#login-box").toggle("slow");
});
$("#showlogin").click(function() {
    $("#login-form-admin").toggle();
    $("#login-form-guest").toggle();
    $("#login-box").animate({
        height: "360px"
    }, 200);
});
$("#showguest").click(function() {
    $("#login-form-admin").toggle();
    $("#login-form-guest").toggle();
    $("#login-box").animate({
        height: login_box_height
    }, 200);
});

//文章目录展开/关闭
$("#toggle").click(function() {
    //$(this).text($("#post-category").is(":hidden") ? "收起" : "展开");
    $("#post-category").slideToggle();
});
//左侧信息展示/关闭 
$("#info-toggle").click(function() {
    $("#ownerinfo").slideToggle();
    $("#sidebar-r").slideToggle();
    $("#Comments_Recent,#Post_Recent").slideToggle();

});
//最近文章展示/关闭
$('.userbox-head').click(function() {
    $("#ownerinfo").slideToggle();
    $("#sidebar-r").slideToggle();
    $("#Comments_Recent,#Post_Recent").slideToggle();
});
//如果宽度小于800则关闭最近文章
if ($(document).width() < 800) {
    $("#Comments_Recent,#Post_Recent").hide();
}
// 打开文章目录
$(".rightside-article-list-btn").click(function() {
    $("#closetoc_msk").show();
    $("#article-list-index").attr("class","show top on");
})
//关闭文章目录
$("#closetoc").click(function() {
    $("#article-list-index").attr("class","show top");
})
//评论点赞按钮样式
$(document).on('mouseover', '.single-button', function() {
    $(this).css("color", "#fb7299");
    var cls = $(this).find("i");
    if (cls.attr("class") == "bp-svg-icon single-icon comment") {
        cls.attr("class", "bp-svg-icon single-icon comment-hover")
    }
    if (cls.attr("class") == "custom-like-icon zan") {
        cls.attr("class", "custom-like-icon zan-hover")
    }
});
$(document).on('mouseout', '.single-button', function() {
    $(this).css("color", "");
    var cls = $(this).find("i");
    if (cls.attr("class") == "bp-svg-icon single-icon comment-hover") {
        cls.attr("class", "bp-svg-icon single-icon comment");
    }
    if (cls.attr("class") == "custom-like-icon zan-hover") {
        cls.attr("class", "custom-like-icon zan");
    }
});

//访客登录按钮
$("#guest_login_btn").click(function(){
    $("#login-a").trigger("click");//模拟点击打开信息框
});
//检查访客信息是否填写
$(document).on('blur', '#mail,#author', function() {
    check_guest_info();
});
//改变评论框背景色
$(document).on('mouseover', '#comment_textarea', function() {
    $("#comment_textarea").css({"background-color":"#fff","border":"1px solid #00a1d6"});
});
$(document).on('mouseout', '#comment_textarea', function() {
    $("#comment_textarea").css({"background-color":"#e5e9ef","border":"1px solid #fff"});
});
//提交评论
$("#comment_submit_btn").click(function(){
    if(!hasLogin){
        _comment_value_sync();
        $("#c_submit_btn").trigger("click");
    }
    if(hasLogin){
        $("#c_submit_btn").trigger("click");
    }
});

/*
 * 自定义函数
 */

//登录框动画
function login_box_animate() {
    if ($("#login-box").is(":hidden")) {
        $(".login").animate({
            right: "342px"
        }, 800);
        $("#login-box").animate({
            height: login_box_height,
            right: "0px"
        }, 800);
    } else if ($("#login-box").is(":visible")) {
        $(".login").animate({
            right: "40px"
        }, 800);
        $("#login-box").animate({
            height: "0px",
            right: "302px"
        }, 800);
    };
}

//检查访客信息是否填写

function check_guest_info() {
    var _guest_username=$("#author").val(),
        _guest_mail = $("#mail").val(),
        _gravatar_url = "https://cdn.v2ex.com/gravatar/" + md5(_guest_mail);
    if (_guest_username !=="" && _guest_mail !== "" && document.getElementById('comment-form')) {
        document.getElementsByClassName('baffle-wrap')[0].style.display = "none";
        document.getElementById('user-head').src = _gravatar_url;
        document.getElementById('login-img').src = _gravatar_url;
        $("#comment_submit_btn").attr("class","comment-submit");
        $("#comment_submit_btn").attr("disabled",false);
    }
}
//制造表单提交评论
// function _c_c_s_form() {
//     var c_author = $("#author").val();// 在指定区域内获得input值
//     var c_mail = $("#mail").val();// 在指定区域内获得input值
//     var c_url = $("#url").val();// 在指定区域内获得input值
//     var c_text = $("#comment_textarea").val();// 在指定区域内获得input值
//     var cForm = $('<form id="comment_submit_form" style="display:none;"></form>');// 创建form标签
//     cForm.attr('action', comment_submit_url);// 创建form属性action
//     cForm.attr('method', 'post');// 创建form属性method
//     cForm.attr('role', 'form');// 创建form属性role
//     var author_input = $('<input type="text" name="author"  required  />');// 创建input标签并隐藏
//     author_input.attr('value', c_author);// 为input标签赋值
//     var mail_input = $('<input type="email" name="mail" required />');// 创建input标签并隐藏
//     mail_input.attr('value', c_mail);// 为input标签赋值
//     var url_input = $('<input type="url" name="url" required />');// 创建input标签并隐藏
//     url_input.attr('value', c_url);// 为input标签赋值
//     var token_input = $('<input type="hidden" name="_" />');// 创建input标签并隐藏
//     token_input.attr('value', comment_submit_token);// 为input标签赋值
//     var text_textarea = $('<textarea rows="8" cols="50" name="text" required></textarea>');// 创建input标签并隐藏
//     text_textarea.val(c_text);// 为input标签赋值
//     var submit_btn = $('<button type="submit" id="c_submit_btn">提交评论</button>');// 创建提交按钮并隐藏
//     cForm.append(author_input);// 将input标签放入新创建的form中
//     cForm.append(mail_input);// 将input标签放入新创建的form中
//     cForm.append(url_input);// 将input标签放入新创建的form中
//     cForm.append(text_textarea);// 将input标签放入新创建的form中
//     cForm.append(submit_btn);// 将input标签放入新创建的form中
//     cForm.appendTo('body');// .submit()最重要的一步，必须将新创建的form放入到body中，浏览器会进行渲染，否则没有效果
//     $("#c_submit_btn").trigger("click");//模拟点击打开信息框
//     return false;// 取消默认动作
// };
//同步表单内容
function _comment_value_sync(){
    var sync_author = $("#sync_author"),
        sync_mail = $("#sync_mail"),
        sync_url = $("#sync_url");
        sync_author.val($("#author").val());
        sync_mail.val($("#mail").val());
        sync_url.val($("#url").val());   
}

//平滑滚动

function phgd() {
    var $root = $('html, body'); //选择器缓存起来。这样每次点击时就不需要再重新查找了
    $('.post-content a').click(function() {
        var href = $.attr(this, 'href');
        $root.animate({
            scrollTop: $(href).offset().top
        }, 500, function() {
            window.location.hash = href;
        });
        return false;
    });
}

//滚动加载

function blog_load_more() {
    $('#spinner').show();
    $.ajax({
        type: 'get',
        url: SITE.default_url + '/page/' + parseInt(page + 1),
        success: function(data, textStatus, XMLHttpRequest) {
            // console.log(data);
            // console.log(textStatus);
            // console.log(XMLHttpRequest);
            page++;
            if (textStatus == "nocontent") {
                $('#nomore').show();
                nocontent = true;
                scrollFun = true;
            } else {
                $('.index-post').append(data);
                scrollFun = false;
            };
            $('#spinner').hide();
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            $('#spinner').hide();
            scrollFun = false;
            $.jGrowl.defaults.position = 'center';
            $.jGrowl('Network Error');
        }
    });
}

//获取视图大小

function getViewportSize(w) {
    //使用指定的窗口， 如果不带参数则使用当前窗口
    w = w || window;

    //除了IE8及更早的版本以外，其他浏览器都能用
    if (w.innerWidth != null)
        return {
            w: w.innerWidth,
            h: w.innerHeight
    };

    //对标准模式下的IE（或任意浏览器）
    var d = w.document;
    if (document.compatMode == "CSS1Compat")
        return {
            w: d.documentElement.clientWidth,
            h: d.documentElement.clientHeight
    };

    //对怪异模式下的浏览器
    return {
        w: d.body.clientWidth,
        h: d.body.clientHeight
    };
}

//检测滚动条是否滚动到页面底部

function isScrollToPageBottom() {
    //文档高度
    var documentHeight = document.documentElement.offsetHeight;
    var viewPortHeight = getViewportSize().h;
    var scrollHeight = window.pageYOffset ||
        document.documentElement.scrollTop ||
        document.body.scrollTop || 0;

    return documentHeight - viewPortHeight - scrollHeight < 20;
}

//加载文章目录

function loadTOC() {
    $(".post-content").children().each(function(index, element) {
        var tagName = $(this).get(0).tagName,
            H_code = tagName.substr(0, 2).toUpperCase();
        if (H_code == "H1" || H_code == "H2" || H_code == "H3" || H_code == "H4"|| H_code == "H5" ) {
            var contentH = $(this).text(); //获取内容
            //标题大于15字符自动加省略号
            if (contentH.length > 15) {
                contentH = contentH.substring(0, 15) + "...";
            }
            if (contentH.length < 1) {
                contentH = "？？？";
            }
            var markid = index.toString();
            $(this).attr("id", markid); //为当前h标签设置id
            $(this).attr("class", "post-content-subtitle");
            $("#post-category").append(' <a class="article-item " href="#'+ markid +'" target="_self"><span class="point"></span><span class="title">'+ contentH +'</span></a>'); //在目标DIV中添加内容 
        }
    });
}
//导航目录高亮

function tochl() {
    // $sections包含与菜单项相关的所有容器div。
    var $sections = $('.post-content-subtitle');

    // The user scrolls
    $(window).scroll(function() {

        // currentsroll是窗口被滚动的像素数
        var currentScroll = $(this).scrollTop();

        // $currentSection是放置我们必须查看的部分的位置
        var $currentSection = $(this);

        // 我们将每个div的位置与windows滚动位置进行比较
        $sections.each(function() {
            // divPosition是我们正在测试的当前部分在px中页面下方的位置     
            var divPosition = $(this).offset().top;

            // 如果div position小于currentcoll位置，则我们正在测试的div已移动到窗口边缘上方。
            //在div离开窗口顶部之前，-1包括div 1px。
            if (divPosition - 20 < currentScroll) {
                // 我们要么读了这一节，要么正在读这一节，所以我们称之为当前节
                $currentSection = $(this);

                // 如果下一个div也已被读取，或者我们正在读取它，我们将再次覆盖该值。这将留给我们最后一个通过的div。
            }

            //这是使用currentSection作为其ID源的代码位
            var id = $currentSection.attr('id');
            $('a').removeClass('tocactive');
            $("[href=#" + id + "]").addClass('tocactive');

        })

    });
    console.clear();
}

// 把搜索记录保存在localStorage
function setHistoryItems(keyword) {
    let { historyItems } = localStorage;
    if (historyItems === undefined) {
      localStorage.historyItems = keyword;
    } else {
      const isNotExists = historyItems.split('|').filter((e) => e == keyword).length == 0;
      if (isNotExists) localStorage.historyItems += '|' + keyword;
    }
}

function googleanalytics() {
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-123390780-1');
}

function closeside(e) {
    if (e == 'l') {
        if ($('#sidebar-l').css('display') == 'none') {
            $('#sidebar-l').css({
                'display': 'block'
            })
            $('#pjax-container').addClass('col-md-6').removeClass('col-md-9')
            $('#closelside').val('关闭左侧栏')
        } else {
            $('#pjax-container').addClass('col-md-9').removeClass('col-md-6')
            $('#sidebar-l').css({
                'display': 'none'
            })
            $('#closelside').val('显示左侧栏')
        }
    }
    if (e == 'r') {
        if ($('#sidebar-r').css('display') == 'none') {
            $('#sidebar-r').css({
                'display': 'block'
            })
            $('#pjax-container').addClass('col-md-6').removeClass('col-md-9')
            $('#closerside').val('关闭右侧栏')
        } else {
            $('#sidebar-r').css({
                'display': 'none'
            })
            $('#pjax-container').addClass('col-md-9').removeClass('col-md-6')
            $('#closerside').val('显示右侧栏')
        }
    }
}

function loadaplayer() {
    var id = $('#loadaplayer').val()
    var code = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.css"><div id="haplayer"></div><script src="https://cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.js"></script><script>$.get("https://api.fczbl.vip/163/?server=netease&type=playlist&id=' + id + '",function(data){const hap = new APlayer({container: document.getElementById("haplayer"),listFolded: false,listMaxHeight: 90,lrcType: 3,audio: data});})</script>'
    $('#metingjsplayer').html(code)
}