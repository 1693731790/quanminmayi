$(function() {
		//导航菜单
	$(".main-tree > ul > li").hover(
		function() {
			clearTimeout($(this).data("hiddenTimer"));
			$(this).children("a").addClass("tree-redtext").siblings("div").show();
		},
		function() {
			var obj = this;
			$(this).data("hiddenTimer", setTimeout(function() {
				$(obj).children("a").removeClass("tree-redtext").siblings("div").hide();
			}, 100))
		}
	)
	//top部分网站导航
	$(".topnav-divider").hover(function() {
		$(this).children("a").toggleClass("topnav-cur").siblings(".topnav-divcon").toggle()
	})
	//top部分蚂蚁商城
	$(".qm-top ul li:eq(0)").hover(function() {
		$(this).children("a").toggleClass("topnav-cur").siblings(".topnav-divcon").toggle()
	})
	//top部分客户服务
	$(".qm-top ul li:eq(1)").hover(function() {
		$(this).children("a").toggleClass("topnav-cur").siblings(".topnav-divcon").toggle()
	})
	//top部分收藏夹
	$(".qm-top ul li:eq(2)").hover(function() {
		$(this).children("a").toggleClass("topnav-cur").siblings(".topnav-divcon").toggle()
	})
	//top部分收藏夹
	$(".qm-top ul li:eq(3)").hover(function() {
		$(this).children("a").toggleClass("topnav-cur").siblings(".topnav-divcon").toggle()
	})
	//top部分收藏夹
	$(".qm-top ul li:eq(5)").hover(function() {
		$(this).children("a").toggleClass("topnav-cur").siblings(".topnav-divcon").toggle()
	})
	//搜索框获取焦点历史记录
	$(".search-div input[type=text]").focus(function() {
		$(this).parents(".search-div").find(".search-divcon").show();
	})
	$(".search-div input[type=text]").blur(function() {
		$(this).parents(".search-div").find(".search-divcon").hide();
	});
	//右侧固定导航回到底部
	$("#qm-top").click(function() {
		$("html,body").animate({
			scrollTop: 0
		}, 600);
		return false;
	})
	//右侧固定购物车
	$(".qm-shoppingcar").click(function() {
		if($(".qm-rightshoppingcar").css("right") == "-280px") {
			$(this).addClass("qm-rightacur")
			$(".qm-rightshoppingcar").stop().animate({
				right: "30px"
			}, 300);
		} else {
			$(this).removeClass("qm-rightacur")
			$(".qm-rightshoppingcar").stop().animate({
				right: "-280px"
			}, 300)
		}
	})
	//右侧固定购物车关闭x
	$(".close-btn").click(function() {
		$(".qm-shoppingcar").removeClass("qm-rightacur")
		$(".qm-rightshoppingcar").stop().animate({
			right: "-280px"
		}, 300)
	})
});