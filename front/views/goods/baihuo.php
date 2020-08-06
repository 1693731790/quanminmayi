<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品列表";
?>


<link href="/shuang11/bhstatic/css/ant_special_20191102.css" rel="stylesheet" type="text/css">




	<div class="special-department-store">
		<!--banner start-->
		<div class="special-department-store-banner clearfix">
			<img src="/shuang11/bhstatic/images/banner.jpg">
        </div>
		<!--banner end-->
		<div class="special-department-store-con clearfix">
		   <!--part1 start-->
		   <div class="special-department-store-part1 swiper-container">
		   	   <div class="special-department-store-part1-con swiper-wrapper">
                   <?php foreach($goods as $key=>$goodsVal):?>
                   <?php if($key<6):?>
		   	   	    <div class="swiper-slide">
		   	   	    	<a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>">
		   	   	    	  <img src="<?=$goodsVal["goods_thums"]?>">
		   	   	    	  <p class="text-overflow"><em>￥</em><?=$goodsVal["price"]?></p>
		   	   	        </a>
		   	   	    </div>
		   	   	   <?php else:?>
                <?php break;?>
                 <?php endif;?>
   <?php endforeach;?>
		   	   	   
		   	   	</div>
		   </div>
		   <!--part1 end-->
	       <!--part2 start-->
	       <div class="special-department-store-tit">
			<em></em>精品百货  保质保量<em></em>
		   </div>
		   <div class="special-department-store-part2 clearfix">
		   	   <ul  class="clearfix">
		   	   	  <?php foreach($goods as $key=>$goodsVal2):?>
                   <?php if($key>6):?>
		   	   	   	<li>
		   	   	   	   <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal2["goods_id"]])?>">
			   	   	   	   <div class="div-img"><img src="<?=$goodsVal2["goods_thums"]?>"></div>
			   	   	   	   <p class="p01"><?=$goodsVal2["goods_name"]?></p>
			   	   	   	   <p class="p02 text-overflow"><em>￥</em><?=$goodsVal2["price"]?></p>
			   	   	   	   <p class="p03"><button class="btn-02">立即购买</button></p>
		   	   	   	   </a>
		   	   	   	</li>
                 <?php endif;?>
   <?php endforeach;?>
                 
		   	   </ul>
		   </div>
		   <!--part2 end-->
	    </div>
	</div>

<script type="text/javascript">
 var departmentStoreSwiper = new Swiper('.special-department-store-part1', {
    speed: 2500,
    loop: true,
    autoplay: {
      disableOnInteraction: false,
      delay: 2500,
    },
    autoplayDisableOnInteraction:false,
    preventLinksPropagation:true,
    slidesPerView : 4,
    centeredSlides: true,                            
   });
</script>