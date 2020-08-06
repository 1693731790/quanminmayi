<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品列表";
?>

<link href="/shuang11/smstatic/css/ant_special_20191103.css" rel="stylesheet" type="text/css">

<div class="special-digital">
		<!--banner start-->
		<div class="special-digital-banner clearfix">
			<img src="/shuang11/smstatic/images/banner.jpg">
        </div>
		<!--banner end-->
	    <div class="special-digital-con">
	    	<!--part1 start-->
	        <div class="special-digital-tit">
			  <span>数码生活  引领时尚</span><em></em>
		    </div>
		    <div class="special-digital-part1">
		   	   <ul class="clearfix">
		   	   	    <?php foreach($goods as $key=>$goodsVal):?>
                   <?php if($key<2):?>
                 <li>
		   	   	   	    <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>">
			   	   	   	   <div class="div-img"><img src="<?=$goodsVal["goods_thums"]?>"></div>
			   	   	   	   <p class="p01 text-overflow"><?=$goodsVal["goods_name"]?></p>
			   	   	       <p class="p02"><button class="btn-01 text-overflow"><span>￥</span><?=$goodsVal["price"]?></button></p>
		   	   	   	   </a>
		   	   	   	</li>
		   	   	   <?php else:?>
                <?php break;?>
                 <?php endif;?>
   <?php endforeach;?>
		   	    </ul>
		    </div>
	        <!--part1 end-->
	        <!--part2 start-->
	        <div class="special-digital-tit">
			  <span>数码潮生活  畅游新时代</span><em></em>
		    </div>
		    <div class="special-digital-part1">
		   	    <ul class="clearfix">
		   	   	   
                  <?php foreach($goods as $key=>$goodsVal2):?>
                   <?php if($key>2):?>
                  <li>
		   	   	   	   <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal2["goods_id"]])?>">
			   	   	   	   <div class="div-img"><img src="<?=$goodsVal2["goods_thums"]?>"></div>
			   	   	   	   <p class="p01 text-overflow"><?=$goodsVal2["goods_name"]?></p>
			   	   	       <p class="p02"><button class="btn-01 text-overflow"><span>￥</span><?=$goodsVal2["price"]?></button></p>
		   	   	   	   </a>
		   	   	   	</li>
		   	   	        
                 <?php endif;?>
   <?php endforeach;?>
		   	   	</ul>
		    </div>
	        <!--part2 end-->
	    </div>
	</div>