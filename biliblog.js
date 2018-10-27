$(document).pjax('a[target!=_blank]', '#pjax-container');
$(document).on('pjax:send', function() {
  NProgress.start();
})
$(document).on('pjax:start', function() {
  //$("#pjax-container").fadeOut(100);
})

$(document).on('pjax:complete', function() {
  NProgress.done();
  NProgress.remove();
  //$("#pjax-container").fadeIn(100);
})
$(document).on('pjax:complete', function() {
    loadSmilies();
    loadTOC();
    $("#smartFloat").smartFloat();
    loadlike();
    closetoc();
    googleanalytics();
    //pjax加载完成之后调用重载函数
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
                var markid="mark-"+tagName+"-"+index.toString();
                $(this).attr("id",markid);//为当前h标签设置id
                $("#post-category").append("<li ><a href='#"+markid+"' style='font-size:14px;display:block;' >"+"  "+contentH+"</a>"+"</li>");//在目标DIV中添加内容   
            }  
        });
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
      top: 0 ,
      width:"262px",
      right: "6%"
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
  gtag('config', 'UA-123390780-1');//把这里修改为自己的统计代码
}
