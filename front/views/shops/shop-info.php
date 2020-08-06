<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title =$shop->name;
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?=$shop->name?></title>
<link rel="stylesheet" type="text/css" href="/shopstatic/font/storeiconfont.css">
<link rel="stylesheet" type="text/css" href="/shopstatic/css/index.css">
<link rel="stylesheet" type="text/css" href="/shopstatic/css/swiper.min.css">
<script type="text/javascript" src="/shopstatic/js/jquery1.42.min.js"></script>
<script type="text/javascript" src="/shopstatic/js/swiper.min.js"></script>
<script type="text/javascript" src="/shopstatic/js/public.js"></script>
<!--头部-->
<header > 
  
 <div class="store-header ">
 	<h1 class="text-overflow"><?=$shop->name?></h1>
 	<div class="store-header-div">
 		<input type="text" id="searchKey" name="key" placeholder="请输入搜索内容">
 		<i class="storeiconfont store-search" id="searchSub"></i>
      <input type="hidden" id="searchType" value="1">
 	</div>
 </div> 
 
  <script type="text/javascript">
      
      $(function(){
        $("#searchSub").click(function(){
            var type=$("#searchType").val();
            
            var key=$("#searchKey").val();

            if(key=="")
            {
                layer.msg("请输入要搜索的内容");
                return false;
            }
            if(type==1)
            {
                var url="<?=Url::to(['search/goods',"shop_id"=>$shop_id])?>";
                window.location.href=url+"&searchKey="+key;
            }else{
                var url="<?=Url::to(['search/shops',"shop_id"=>$shop_id])?>";
                window.location.href=url+"&searchKey="+key;
            }
            
        })
    })
</script> 
</header>
<section>
	<!--banner start-->
  <?php if(!empty($shopBanner)):?>
	<div class="store-banner">
	    <div class="store-banner-swiper swiper-container">
		  <div class="swiper-wrapper">
		  <?php foreach($shopBanner as $bannerVal):?>
            <div class="swiper-slide"><a href="<?=$bannerVal->url?>"><img src="<?=$bannerVal->img?>"></a></div>
		  <?php endforeach;?>
		  </div>
		  <div class="store-slider-pagination"></div>
		</div>
    </div>
    <?php endif;?>
    <!--banner end-->
    <!--余额 start-->
	<!--<div class="store-balance">
		<em></em>
		我的余额：￥<span>
      	<?=empty($user)?"请先登录":$user->recharge_fee?>
      	</span>元
      	<?php if(empty($user)):?>
			<div class="store-balance-login"><a href="<?=Url::to(["site/login"])?>">登录充值</a></div>
      	<?php else:?>
      		<div class="store-balance-login"><a href="<?=Url::to(["user/recharge-card"])?>">充值</a></div>
      	<?php endif;?>
	</div>-->
	<!--余额 end-->
	<!--nav start-->
  <?php if(!empty($shopCate)):?>
	<div class="store-nav clearfix" >
		<ul>
           <?php foreach($shopCate as $cateVal):?>
          	<li>
				<a href="<?=Url::to(["goods/index","shop_id"=>$shop_id,"shops_cate"=>$cateVal->id])?>">
					<div class="div-img"><div><img src="<?=$cateVal->img?>"></div></div>
					<p class="text-overflow"><?=$cateVal->title?></p>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="store-nav-more">
		<a href="<?=Url::to(["shops/shop-cate","shop_id"=>$shop_id])?>">查看更多品牌</a>
	</div>
  <?php endif;?>
	<!--nav end-->
  <?php if(!empty($shopsLimit)):?>
	<!--兑换专区 start-->
	<div class="store-exchange">
		<div class="store-exchange-tit">
			<em><img src="/shopstatic/images/store_time.png"></em>
			兑换专区，超值限量
			<a href="<?=Url::to(["goods/index","shop_id"=>$shop_id,"shops_limit"=>1])?>">更多 >>></a>
		</div>
		<div class="store-exchange-ul">
			<ul>
                <?php foreach($shopsLimit as $shopsLimitVal):?>
				<li>
					<a href="<?=Url::to(["goods/detail","goods_id"=>$shopsLimitVal->goods_id])?>">
						<div class="div-img">
							<img src="<?=$shopsLimitVal->goods_thums?>">
					    </div>
						<div>
	                       <p class=" text-overflow"><?=$shopsLimitVal->goods_name?></p>
	                       <p>
	                       	  <span class="sp01">¥<?=$shopsLimitVal->price?></span>
	                          <span class="sp02">¥<?=$shopsLimitVal->old_price?></span>
	                       </p>
						</div>
				    </a>
				</li>
              <?php endforeach;?>
				
			</ul>
		</div>
	</div>
    <?php endif;?>
	<!--兑换专区 end-->
  <?php if(!empty($shopCate)):?>
	<!--分区 start-->
	<div class="store-part-img clearfix">
		<?php foreach($shopClass as $classValue):?>
            <a href="<?=Url::to(["goods/index","shop_id"=>$shop_id,"shops_class"=>$classValue->id])?>">
                <img src="<?=$classValue->img?>">
            </a>
        <?php endforeach;?>
	</div>
    <!--分区 end-->
  <?php endif;?>
  
   <?php if(!empty($goods1)):?>
	<!--part1 start-->
	<div class="store-part-img clearfix">
		<a href="javascript:;">
			<img src="/shopstatic/images/200zq.png">
		</a>
	</div>
	<div class="store-part-ul clearfix">
		<ul >
			<?php foreach($goods1 as $goods1Val):?>
           
			<li>
				<a href="<?=Url::to(["goods/detail","goods_id"=>$goods1Val->goods_id])?>">
					<div class="div-img">
						<img src="<?=$goods1Val->goods_thums?>">
				    </div>
					<div>
                       <p class="p01"><?=$goods1Val->goods_name?></p>
                       <p>
                       	  <span class="sp01 text-overflow"><em>¥</em><?=$goods1Val->price?></span>
                          <span class="sp02 text-overflow">¥<?=$goods1Val->old_price?></span>
                       </p>
					</div>
			    </a>
			</li>
           <?php endforeach;?>
		</ul>
	</div>
	<div class="store-part-more clearfix">
		<a href="<?=Url::to(["goods/index","shop_id"=>$shop_id,"price1"=>"1"])?>">查看更多</a>
	</div>
   <?php endif;?>
    <!--part1 end-->
  <?php if(!empty($goods2)):?>
    <!--part2 start-->
    <div class="store-part-img clearfix">
		<a href="javascript:;">
			<img src="/shopstatic/images/200_500zq.png">
		</a>
	</div>
	<div class="store-part-ul clearfix">
		<ul>
			<?php foreach($goods2 as $goods2Val):?>
			<li>
				<a href="<?=Url::to(["goods/detail","goods_id"=>$goods2Val->goods_id])?>">
					<div class="div-img">
						<img src="<?=$goods2Val->goods_thums?>">
				    </div>
					<div>
                       <p class="p01"><?=$goods2Val->goods_name?></p>
                       <p>
                       	  <span class="sp01 text-overflow"><em>¥</em><?=$goods2Val->price?></span>
                          <span class="sp02 text-overflow">¥<?=$goods2Val->old_price?></span>
                       </p>
					</div>
			    </a>
			</li>
           <?php endforeach;?>
		</ul>
	</div>
	<div class="store-part-more clearfix">
		<a href="<?=Url::to(["goods/index","shop_id"=>$shop_id,"price2"=>"1"])?>">查看更多</a>
	</div>
    <?php endif;?>
  
   <?php if(!empty($goods3)):?>
    <!--part2 start-->
    <div class="store-part-img clearfix">
		<a href="javascript:;">
			<img src="/shopstatic/images/500_1000zq.png">
		</a>
	</div>
	<div class="store-part-ul clearfix">
		<ul>
			<?php foreach($goods3 as $goods3Val):?>
			<li>
				<a href="<?=Url::to(["goods/detail","goods_id"=>$goods3Val->goods_id])?>">
					<div class="div-img">
						<img src="<?=$goods3Val->goods_thums?>">
				    </div>
					<div>
                       <p class="p01"><?=$goods3Val->goods_name?></p>
                       <p>
                       	  <span class="sp01 text-overflow"><em>¥</em><?=$goods3Val->price?></span>
                          <span class="sp02 text-overflow">¥<?=$goods3Val->old_price?></span>
                       </p>
					</div>
			    </a>
			</li>
           <?php endforeach;?>
		</ul>
	</div>
	<div class="store-part-more clearfix">
		<a href="<?=Url::to(["goods/index","shop_id"=>$shop_id,"price3"=>"1"])?>">查看更多</a>
	</div>
    <?php endif;?>
  
   <?php if(!empty($goods3_)):?>
    <!--part2 start-->
    <div class="store-part-img clearfix">
		<a href="javascript:;">
			<img src="/shopstatic/images/1000_2000zq.png">
		</a>
	</div>
	<div class="store-part-ul clearfix">
		<ul>
			<?php foreach($goods3_ as $goods3_Val):?>
			<li>
				<a href="<?=Url::to(["goods/detail","goods_id"=>$goods3_Val->goods_id])?>">
					<div class="div-img">
						<img src="<?=$goods3_Val->goods_thums?>">
				    </div>
					<div>
                       <p class="p01"><?=$goods3_Val->goods_name?></p>
                       <p>
                       	  <span class="sp01 text-overflow"><em>¥</em><?=$goods3_Val->price?></span>
                          <span class="sp02 text-overflow">¥<?=$goods3_Val->old_price?></span>
                       </p>
					</div>
			    </a>
			</li>
           <?php endforeach;?>
		</ul>
	</div>
	<div class="store-part-more clearfix">
		<a href="<?=Url::to(["goods/index","shop_id"=>$shop_id,"price3_"=>"1"])?>">查看更多</a>
	</div>
    <?php endif;?>
  
  
	<!--part2 end-->
	<!--part3 start-->
	<div class="store-part-tit clearfix">热销产品</div>
	<div class="store-part-ul clearfix">
		<ul id="list_box">
			
			<?php foreach($goodsall as $goodsallVal):?>
			<li>
				<a href="<?=Url::to(["goods/detail","goods_id"=>$goodsallVal->goods_id])?>">
					<div class="div-img">
						<img src="<?=$goodsallVal->goods_thums?>">
				    </div>
					<div>
                       <p class="p01"><?=$goodsallVal->goods_name?></p>
                       <p>
                       	  <span class="sp01 text-overflow"><em>¥</em><?=$goodsallVal->price?></span>
                          <span class="sp02 text-overflow">¥<?=$goodsallVal->old_price?></span>
                       </p>
					</div>
			    </a>
			</li>
           <?php endforeach;?>
		</ul>
	</div>
	<!--part3 end-->
</section>
<!--foot start-->
<footer>
	<div class="store-footer">
		<ul>
			<li>
				<a href="<?=Url::to(["shops/shop-info","shop_id"=>$shop_id])?>">
					<i class="storeiconfont store-index"></i>
					<p>首页</p>
				</a>
			</li>
			<li>
                <a href="<?=Url::to(["shops/shop-cate","shop_id"=>$shop_id])?>">
					<i class="storeiconfont store-fenlei"></i>
					<p>产品分类</p>
				</a>
			</li>
			<li>
				<a href="<?=Url::to(["shopcar/shopcar-list"])?>">
					<i class="storeiconfont store-car"></i>
					<p>购物车</p>
				</a>
			</li>
			<li>
				<a href="<?=Url::to(["user/index"])?>">
					<i class="storeiconfont store-my"></i>
					<p>我的</p>
				</a>
			</li>
		</ul>
	</div>
</footer>	
<!--foot end-->
<script type="text/javascript">
	var swiper = new Swiper('.store-banner-swiper', {
		speed: 600,
	    loop: true,
	    autoplay: {
	        delay: 5000,
	        disableOnInteraction: true,
	    },
		// autoHeight: true,
		pagination: {
			el: '.store-slider-pagination',
			clickable: true,
		}
    });
</script>
<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据 
 function LoadingDataFn() {
    $.get("<?=Url::to(['shops/goods-list'])?>",{"page":page,"shop_id":"<?=$shop_id?>"},function(da){
             $('#list_box').append(da);                                      
    })
   
    
    off_on = true; //[重要]这是使用了 {滚动加载方法1}  时 用到的 ！！！[如果用  滚动加载方法1 时：off_on 在这里不设 true的话， 下次就没法加载了哦！]
};

$(window).scroll(function() {
    //当时滚动条离底部60px时开始加载下一页的内容
    if (($(window).height() + $(window).scrollTop() + 60) >= $(document).height()) {
        clearTimeout(timers);
        timers = setTimeout(function() {
            page++;
            
            LoadingDataFn();
        }, 300);
    }
});
</script>