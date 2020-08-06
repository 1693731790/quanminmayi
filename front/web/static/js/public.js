//处理REM单位核心代码
        (function (doc, win) {
          var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
              var clientWidth = docEl.clientWidth;
              if (!clientWidth) return;
              docEl.style.fontSize = 20 * (clientWidth / 320) + 'px';
			  doc.getElementsByTagName("body")[0].style.opacity='1';
            };

          if (!doc.addEventListener) return;
          win.addEventListener(resizeEvt, recalc, false);
          doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
//页面载入所执行函数
$(function() {
	scrollUp();
	Set_ClassificationTabs()
})
//首页分类宽度设置
function Set_ClassificationTabs(){
    var num = $('#ClassificationTab').find('li').length;
    $('#ClassificationTab').find('ul').width((num * 3.8) + "rem");
}



//返回顶部
function scrollUp(){
/*$.scrollUp({
        scrollName:'scrollUp',// 元素ID
        topDistance:'300',// 顶部距离显示元素之前 (px)
        topSpeed:300,// 回到顶部的速度 (ms)
        animation:'fade',// 动画类型Fade, slide, none
        animationInSpeed:200,
        animationOutSpeed:200,
        scrollText:'TOP',// 元素文本
        activeOverlay:false,// 显示scrollUp的基准线，false为不显示, e.g '#00FFFF'
    });*/
}


//选中切换
function select_switch(name,cls){
$(name).toggleClass(cls);
}


//滚动加载
function SrollLoad(num,maxnum,url,insert,kl){
    var range = 20;       //距下边界长度/单位px  
    var maxnum = maxnum;  //设置加载最多次数  
    loaded = true;
    var totalheight = 0;
    var main  =$(insert); //主体元素
    
	
    function Add_Data() {
        var srollPos = $(window).scrollTop();
        var cid   =$("#cid2").val();
        var key   =$("#key").val();
        if(!key){
        	key=0;
        }
        totalheight = parseFloat($(window).height()) + parseFloat(srollPos);
        if (loaded && ($(document).height() - range) <= totalheight && num != maxnum) { 
            var page2 =$("#page2").val();
		    page2=parseInt(page2)+1;
		    $("#page2").val(page2);
			loaded=false;
			$.ajax({
              type: 'post',
              url: url,
              dataType: 'html',
      	      data: { "cid":cid,"page":page2,"key":key},
			  param:{pageNo:2},
			  cache:false,
              success: function(data){
				  $(insert).append(data);
				  loaded=true;
				  //判断分页已经累加到总数
				  if (page2==(maxnum-1)) {
					  $('#Loading').html('没有更多了');
					  loaded=false;
				  }
              },
			  error:function(data){
				//错误提示
				//alert('数据加载失败')
			} 			  
            });
        }
    }
    $(window).scroll(function() {
    	 /*var scrollTop = $(this).scrollTop();
		　var scrollHeight = $(document).height();
		　var windowHeight = $(this).height();
		　if(scrollTop + windowHeight == scrollHeight && scrollHeight>1300 && page2<(maxnum-1)){
		      Add_Data();
		　}*/
		 Add_Data();
    })
}



//跳转页面	
function GoToUrl(url) {
    window.location.href = url;
}
//分类页面选项卡
$(function() {
    $('.LargeClassification li').click(function() {
        $(this).addClass('on').siblings('li').removeClass('on');
        var index = $(this).index() + 1;
        myScroll.scrollToElement(document.querySelector('#scroller li:nth-child(' + index + ')'), 500)

    })
})


//------------------------------------------购物车------------------------------------------
//开启关闭编辑状态
$(function (){
	$('.EditBut').click(function (){
		var Info=$(this).parents('.Tit').next('.ProList').find('.pl20');
		var Edit=$(this).parents('.Tit').next('.ProList').find('.Edit');
		if(Info.is(":visible")==true){
			$(this).text('完成');
			Info.hide();
			Edit.show();
		}
		else{
			$(this).text('编辑');
			Info.show();
			Edit.hide();
		}
	})
	
})
//数量增减
$(function (){
	
	for(i=0; i<$('.num').length;i++)
	{
		var num_t=$('.num').eq(i).text();
		if(num_t==1){
		
		}
	}
		
	

	
	
	    var fnreduce = function(){
		var $ipt = $(this).next('span');
		var num = $ipt.text();
		var maxnum = parseInt($ipt.attr('data-num'));
		if(num>1){
			if(num==maxnum){
				$ipt.next('i').removeClass('no');
			}
			num--;
			$ipt.text(num);
			if(num==1){
				$(this).addClass('no')	
			}
		}
	};
	var fnincrease = function(){
		var $ipt = $(this).prev('span');
		var num = $ipt.text();
		var maxnum = parseInt($ipt.attr('data-num'));
		if(num<maxnum){
			if(num==1){
				$ipt.prev('i').removeClass('no');	
			}
			num++;
			$ipt.text(num);
			if(num==maxnum){
				$(this).addClass('no');
			}
		}
	};
	$('.icon-reduce').click(fnreduce);
	$('.icon-increase').click(fnincrease);
	
})

//分销订单管理选项卡
function DistributionOrder(name){
var index = $(name).index();
$(name).addClass('on').siblings('li').removeClass('on');
$('.ProList').hide();
$('.ProList').eq(index).show();
}


//公用弹窗
function OpenPop(id) {
    $(id).show();
    $(document).bind('touchmove',
    function(event) {
        event.preventDefault();
    });
}

function ClosePop(id) {
    $(id).hide();
    $(document).unbind('touchmove')
}

//模拟下拉框
function SelectData(id) {
    var text = $(id).val();
    $(id).next('.text').val(text);
}


//查看一元购记录
function ViewLog(id){
	$(id).show();
}
//关闭一元购记录
function CloseLog(id){
	$(id).hide();
}







//倒计时
function countdown(Second){
	num=$('.Countdown').find('.num');
	var TotalSecond = parseInt(Second);//倒计时总秒数量
	var timer=null;
	fntime()
	clearInterval( timer );
	timer = setInterval(fntime, 1000);
	function fntime(){
	var day=0,
		hour=0,
		minute=0,
		second=0;//时间默认值		
	if(TotalSecond > 0){
		day = Math.floor(TotalSecond / (60 * 60 * 24));
		hour = Math.floor(TotalSecond / (60 * 60)) - (day * 24);
		hour2=hour+(day*24);
		minute = Math.floor(TotalSecond / 60) - (day * 24 * 60) - (hour * 60);
		second = Math.floor(TotalSecond) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
	}
	if (hour2 <= 9) hour = '0' + hour2;
	if (minute <= 9) minute = '0' + minute;
	if (second <= 9) second = '0' + second;
	var arr=hour2+minute+second;
	
	for(i=0; i<arr.length;i++){
	num.eq(i).html(arr.charAt(i))
	}
	TotalSecond--;
	}
	
} 
//绑定提现帐户
function BindingTab(name){
	$('.select,.ListForms').hide();
	$(name).find('.select').show();
	var index = $(name).index();
	$('.ListForms').eq(index).show();
}	




//通用选项卡
function tabs(name,name2){
	var index = $(name).index();
	$(name).addClass('on').siblings('li').removeClass('on');
	$(name2).hide();
	$(name2).eq(index).show();
}


//评价评心
$(function (){
		$('.score').find('i').click(function (){
		var index=$(this).index();
		var icon=$(this).parents('.score').find('i');
		icon.attr('class','iconfont icon-star')
			for(i=0;i<index+1;i++)
			{
			icon.eq(i).attr('class','iconfont icon-staron');	
			}
	})
})




//选择地址（省）
var onOff=true;
function openAddress(obj){
	$this=$(obj)
	if(onOff){
			$.ajax({
				type: 'post',
				url: ApiUrl + '/index.php?act=member_address&op=area_list',
				data: {
					key: key
				},
				dataType: 'json',
				success: function(result) {
					checklogin(result.login);
					var data = result.datas;
					var prov_html = '';
					for (var i = 0; i < data.area_list.length; i++) {
						prov_html += '<li onclick="province('+"'"+data.area_list[i].area_name+"'"+','+data.area_list[i].area_id+')"  >'+data.area_list[i].area_name+'</li>';
					}
					$("#xianyou").append(prov_html); 
				}
			});
		$('.of').attr('class','of iconfont icon-downdot2');
		$this.show();
		onOff=false;
	}
	else{
		$('.of').attr('class','of iconfont icon-rightdot');
		$this.hide();
		onOff=true;
	}
}
//搜索类型
function SearchType(id){
	$(id).toggle();
}
$(function (){
	$('#TypePop li').click(
    	function(){
		    $('#SearchType').find('span').html($(this).text());
			$('#TypePop').hide();
			if($(this).text()=="商品"){
				$("#kindtype").val(1);
			}
			else if($(this).text()=="店铺"){
				$("#kindtype").val(2);
			}
		}
	)
})