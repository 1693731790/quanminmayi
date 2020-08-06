$(function() {
	//轮播banner图
	var i = 0;
	var timer;
	$(".ig").eq(0).show().siblings().hide(); //页面打开之后，第一张图片显示，其余的图隐藏
	beginLunbo();
	$(".tab").hover(
		function() {
			clearInterval(timer); //清除定时器
			i = $(this).index(); //获取到当前鼠标放上去的对象的索引值，并赋值给i
			showPicTab();
		},
		function() {
			beginLunbo();
		}
	);

	$(".arrow-left").click(function() {
		clearInterval(timer);
		i--;
		if(i == -1) {
			i = 5;
		}
		showPicTab();
		beginLunbo();
	});
	$(".arrow-right").click(function() {
		clearInterval(timer);
		i++;
		if(i == 6) {
			i = 0;
		}
		showPicTab();
		beginLunbo();
	});

	function showPicTab() {
		$(".ig").eq(i).fadeIn(300).siblings().fadeOut(300);
		$(".tab").eq(i).addClass("bg").siblings().removeClass("bg");
		if(i == 0) {
			$(".ig").parents(".qm-banner").css("background-color", "#fe3a3a");
		}
		if(i == 1) {
			$(".ig").parents(".qm-banner").css("background-color", "#47c0f9");
		}
		if(i == 2) {
			$(".ig").parents(".qm-banner").css("background-color", "#01a6ea");
		}
		if(i == 3) {
			$(".ig").parents(".qm-banner").css("background-color", "#4680fe");
		}
		if(i == 4) {
			$(".ig").parents(".qm-banner").css("background-color", "#00006a");
		}
		if(i == 5) {
			$(".ig").parents(".qm-banner").css("background-color", "#4e0bb0");
		}

	}

	function beginLunbo() {
		timer = setInterval(function() {
			i++; //i自增1
			if(i == 6) {
				i = 0;
			}
			showPicTab();
		}, 3000);
	}
	//促销咨询的切换
	$(".Promotion-tit ul li").mousemove(function() {
		$(this).addClass('cur').siblings().removeClass('cur');
		var index = $(this).index();
		$(this).parents(".Promotion").find(".Promotion-con").hide();
		$(this).parents(".Promotion").find('.Promotion-con').eq(index).show();
	})
	//秒杀切换
	$(".seckill-timeinterval ul li").click(function() {
		$(this).addClass('cur').siblings().removeClass('cur');
		var index = $(this).index();
		$(this).parents("#seckill-divcol").find(".seckill-listcon").hide();
		$(this).parents("#seckill-divcol").find('.seckill-listcon').eq(index).show();
	})
	//精选专区,蚂蚁新品,蚂蚁特卖切换
	$(".Boutiquetit span").click(function() {
		$(this).addClass('cur').siblings().removeClass('cur');
		var index = $(this).index();
		$(this).parents("#jingxuan").find(".boutique-listcon").hide();
		$(this).parents("#jingxuan").find('.boutique-listcon').eq(index).show();
	})
	//楼层上边切换
	$(".seckill-timeinterval ul li").hover(function() {
		$(this).addClass('cur').siblings().removeClass('cur');
		var index = $(this).index();
		//楼层商品的切换
		$(this).parents(".floor").find(".floor-productlist").hide();
		$(this).parents(".floor").find('.floor-productlist').eq(index).show();
	})
	//主题馆子类切换
	$(".theme-stage li").click(function() {
		$(this).addClass("cur").siblings().removeClass("cur");
		var index = $(this).index();
		$(this).parents(".qm-themeshop").find(".product-listcon").hide();
		$(this).parents(".qm-themeshop").find(".product-listcon").eq(index).show();
	})
	//主题馆产品点击轮播
	$('.theme-produt ul').carouFredSel({
		prev: '#produt-pre',
		next: '#produt-next',
		scroll: {
			items: 3, //一次滚动3个
			duration: 1000, //滚动持续时间
			timeoutDuration: 10000 //滚动间隔时间
		}
	});
	//轮播右侧广告轮播
	function AppModuleBoxMove() {
		var $box = $('#product-adv');
		var $btnMoveLeft = $('.adv-left', $box);
		var $btnMoveRight = $('.adv-right', $box);
		var $moveBox = $('.product-advcon', $box);
		var $moveList = $('#advlist', $box);
		var moveBoxWidth = $moveBox.width();
		var minMoveLength = -($moveList.width() - moveBoxWidth);
		//左移动点击
		$btnMoveLeft.click(function() {
			if($moveList.is(':animated')) {
				return;
			}
			var moveLst_Left = parseInt($moveList.css('left'));
			var moveLength = moveBoxWidth + (isNaN(moveLst_Left) ? 0 : moveLst_Left);
			if(moveLength > 0) {
				moveLength = 0;
			}
			$moveList.animate({
				left: moveLength,
			}, 500);
		});

		//右移动点击
		$btnMoveRight.click(function() {
			if($moveList.is(':animated')) {
				return;
			}
			var moveLst_Left = parseInt($moveList.css('left'));
			var moveLength = -moveBoxWidth + (isNaN(moveLst_Left) ? 0 : moveLst_Left);
			if(moveLength < minMoveLength) {
				moveLength = minMoveLength;
			}
			$moveList.animate({
				left: moveLength,
			}, 500);
		});
	}
	AppModuleBoxMove();
	//顶部搜索框长栏目的出现
	var resourceoffet = $('.qm-bannercon').offset().top;
	$(document).scroll(function() {
		if(document.documentElement.scrollTop >= resourceoffet || document.body.scrollTop >= resourceoffet) {
			$('#qm-headersearch').show();
		} else {
			$('#qm-headersearch').hide();

		}
	});
	// 左侧楼层滚动
	var babyfloortop = $(".baby-floor").offset().top;
	var bd_height = new Array();
	var old_key = 0;
	$('#ffloorlist .floor').each(function() {
		bd_height[$(this).index()] = $(this).offset().top;
	})
	$(window).scroll(function() {
		var sl_this = $(this).height();
		var sl_top = $(this).scrollTop();
		var show_ht = sl_top + sl_this / 2;
		var key = 0;
		bd_height.map(function(value, index) {
			if(show_ht >= value) {
				key = index;
			}
		})
		if(old_key == key) {
			return false;
		} else {
			old_key = key;
			change_step(key);
		}
	})

	function change_step(key) {
		$(".qm-leftitem").eq(key).addClass("active").siblings().removeClass("active")
	}

	function change_building(key) {
		var sl_this = $(window).height();
		var target = $('.floor').eq(key).offset().top;
		target -= sl_this / 2 - 1;
		$('html,body').animate({
			scrollTop: target
		});
	}
	$(document).scroll(function() {
		var t = $(document).scrollTop();
		if(t >= babyfloortop) {
			width = $(document).width();
			if(width > 1200) {
				left = (width - 1200) / 2 - 145;
				left = left < 0 ? 0 : left;
				$(".qm-leftnav").css("left", left + "px");
			} else {
				$(".qm-leftnav").css("left", "0px");
			}
			$(".qm-leftnav").css("display", "block")

		} else {
			$(".qm-leftnav").css("display", "none")
		}
	});
	//楼层品牌轮播
	$('.floor-brand .floor-brandcon').carouFredSel({
		prev: '.floor-left',
		next: '.floor-right',
		scroll: {
			items: 11, //一次滚动11个
			duration: 1000, //滚动持续时间
			timeoutDuration: 10000 //滚动间隔时间
		}
	});
	$('.floor-brand .floor-brandcon2').carouFredSel({
		prev: '.floor-left2',
		next: '.floor-right2',
		scroll: {
			items: 11, //一次滚动11个
			duration: 1000, //滚动持续时间
			timeoutDuration: 10000 //滚动间隔时间
		}
	});
	$('.floor-brand .floor-brandcon3').carouFredSel({
		prev: '.floor-left3',
		next: '.floor-right3',
		scroll: {
			items: 11, //一次滚动11个
			duration: 1000, //滚动持续时间
			timeoutDuration: 10000 //滚动间隔时间
		}
	});
	$('.floor-brand .floor-brandcon4').carouFredSel({
		prev: '.floor-left4',
		next: '.floor-right4',
		scroll: {
			items: 11, //一次滚动11个
			duration: 1000, //滚动持续时间
			timeoutDuration: 10000 //滚动间隔时间
		}
	});
	$('.floor-brand .floor-brandcon5').carouFredSel({
		prev: '.floor-left5',
		next: '.floor-right5',
		scroll: {
			items: 11, //一次滚动11个
			duration: 1000, //滚动持续时间
			timeoutDuration: 10000 //滚动间隔时间
		}
	});
	$('.floor-brand .floor-brandcon6').carouFredSel({
		prev: '.floor-left6',
		next: '.floor-right6',
		scroll: {
			items: 11, //一次滚动11个
			duration: 1000, //滚动持续时间
			timeoutDuration: 10000 //滚动间隔时间
		}
	});
	$('.floor-brand .floor-brandcon7').carouFredSel({
		prev: '.floor-left7',
		next: '.floor-right7',
		scroll: {
			items: 11, //一次滚动11个
			duration: 1000, //滚动持续时间
			timeoutDuration: 10000 //滚动间隔时间
		}
	});
});