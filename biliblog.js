$(document).pjax('a[target!=_blank]', '#pjax-container');
$.pjax.defaults.timeout = 2000;
$(window).scroll(function () {
  //小屏幕下的导航条折叠
  if ($(window).width() < 768) {
    //点击导航链接之后，把导航选项折叠起来
    $(".navbar-toggle").click(function () {
      $("#navbar-collapse-1").collapse('hide');
    });
    //滚动屏幕时，把导航选项折叠起来
    $(window).scroll(function () {
      $("#navbar-collapse-1").collapse('hide');
    });
  }
});
$(document).on('pjax:send', function() {
  NProgress.start();
  $("#pjax-container").addClass('fadeOut');
  $("#pjax-container").html('<div class="loading" > <img src="https://i.loli.net/2018/10/30/5bd8193caea80.gif" /></div>');
  $('#smartFloat').css({'display':'none'});
})

$(document).on('pjax:complete', function() {
    $("#pjax-container").removeClass('fadeOut');
    $("#pjax-container").addClass('fadeIn');
})
$(document).on('pjax:complete', function() {
    NProgress.done();
    NProgress.remove();
    loadSmilies();
    loadTOC();
    $("#smartFloat").smartFloat();
    loadlike();
    closetoc();
    googleanalytics();
    tochl();
    loadhljs();
    loadbdtj();
    //pjax加载完成之后调用重载函数
});
$(document).ready(function(){
    $('.loading').css({'display':'none'});
    if($(document).width()<775){
    $('#navbar-collapse-1').collapse("hide");
    }
});

$(function(){
        //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
        $(function () {
            $(window).scroll(function(){
                if ($(window).scrollTop()>100){
                    $("#to-top").fadeIn(800);
                }
                else
                {
                    $("#to-top").fadeOut(800);
                }
            });
 
            //当点击跳转链接后，回到页面顶部位置
 
            $("#to-top").click(function(){
                $('body,html').animate({scrollTop:0},1000);
                return false;
            });
        });
    });

function loadSmilies(){
$(function(){
	var box = $("#smiliesbox");
	$("#smiliesbutton").click(function(){
		box.show();
	});
	$("span",box).click(function(){
		$("textarea").insert($(this).attr("data-tag"));
		box.hide();
	});
	$(document).mouseup(function(e){
		if (!box.is(e.target) && box.has(e.target).length === 0) {
			box.hide();
		}
	});
	$.fn.extend({
		"insert": function(myValue){
			var $t = $(this)[0];
			if (document.selection) {
				this.focus();
				sel = document.selection.createRange();
				sel.text = myValue;
				this.focus()
			} else if ($t.selectionStart || $t.selectionStart=="0") {
				var startPos = $t.selectionStart;
				var endPos = $t.selectionEnd;
				var scrollTop = $t.scrollTop;
				$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
				this.focus();
				$t.selectionStart = startPos + myValue.length;
				$t.selectionEnd = startPos + myValue.length;
				$t.scrollTop = scrollTop
			} else {
				this.value += myValue;
				this.focus()
			}
		}
	}) 
});
}    

function loadTOC(){
    $(".post-content").children().each(function(index, element) {
            var tagName=$(this).get(0).tagName;
            if(tagName.substr(0,1).toUpperCase()=="H"){  
                var contentH=$(this).text();//获取内容
                //标题大于15字符自动加省略号
                if(contentH.length>15){
                    contentH=contentH.substring(0,15)+"...";
                }else{
                     contentH=contentH;
                }
                var markid=index.toString();
                $(this).attr("id",markid);//为当前h标签设置id
                $(this).attr("class","post-content-subtitle");
                $("#post-category").append("<li ><a href='#"+markid+"' style='font-size:14px;display:block;' >"+"  "+contentH+"</a>"+"</li>");//在目标DIV中添加内容   
            }  
        });
}

//导航目录高亮
function tochl(){
  // $sections incleudes all of the container divs that relate to menu items.
  var $sections = $('.post-content-subtitle');
  
  // The user scrolls
  $(window).scroll(function(){
    
    // currentScroll is the number of pixels the window has been scrolled
    var currentScroll = $(this).scrollTop();
    
    // $currentSection is somewhere to place the section we must be looking at
    var $currentSection =$(this);
    
    // We check the position of each of the divs compared to the windows scroll positon
    $sections.each(function(){
      // divPosition is the position down the page in px of the current section we are testing      
      var divPosition = $(this).offset().top;
      
      // If the divPosition is less the the currentScroll position the div we are testing has moved above the window edge.
      // the -1 is so that it includes the div 1px before the div leave the top of the window.
      if( divPosition - 1 < currentScroll ){
        // We have either read the section or are currently reading the section so we'll call it our current section
        $currentSection = $(this);
        
        // If the next div has also been read or we are currently reading it we will overwrite this value again. This will leave us with the LAST div that passed.
      }
      
      // This is the bit of code that uses the currentSection as its source of ID
      var id = $currentSection.attr('id');
   	 $('a').removeClass('tocactive');
   	 $("[href=#"+id+"]").addClass('tocactive');
      
    })

  });
  console.clear();
}
$.fn.smartFloat = function() {
 var position = function(element) {
  var top = element.position().top, pos = element.css("position");
  $(window).scroll(function() {
   var scrolls = $(this).scrollTop();
   if (scrolls > top) {
    if (window.XMLHttpRequest) {
     element.css({
      position: "fixed",
      top: 50 ,
      width:"240px"
     }); 
    } else {
     element.css({
      top: scrolls
     }); 
    }
   }else {
    element.css({
     position: pos,
     top: top
    }); 
   }
  });
 };
 return $(this).each(function() {
  position($(this));      
 });

};
 $("#toggle").click(function() {
    $(this).text($("#post-category").is(":hidden") ? "收起" : "展开");
    $("#post-category").slideToggle();
 });
  $("#info-toggle").click(function() {
    $("#ownerinfo").slideToggle();
 });
 $('.userbox-head').click(function(){
    $("#ownerinfo").slideToggle();
 })
 
 function loadlike(){
     $(function(){
	$('#like-btn').click(function(e){
		e.stopPropagation();
		e.preventDefault();
		var that = $(this),num = $(this).data('num'), cid = $(this).data('cid');
		if(cid===undefined) return false;
		$.get(window.action+'likes?cid='+cid).success(function(rs){
			if(rs.status==1){
				//兼容Matrial主题
				$('#like-num').attr('data-badge', num+1);
				$('#like-num').css('color', 'red');
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
 }
 
function closetoc(){
    $("#closetoc").click(function(){
    $("#smartFloat").hide();})
}
function googleanalytics(){
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-123390780-1');
}
//下滑显示导航
$(function(){

var nav=$(".nav-mask"); //得到导航对象

var win=$(window); //得到窗口对象

var sc=$(document);//得到document文档对象。

win.scroll(function(){

  if(sc.scrollTop()>=50){

    nav.addClass("fixednav"); 

   $(".navTmp").fadeIn(); 

  }else{

   nav.removeClass("fixednav");

   $(".navTmp").fadeOut();

  }

})})  

function loadhljs(){
    hljs.initHighlighting();
    hljs.initHighlightingOnLoad();
}