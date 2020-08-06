<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品列表";
?>

<link href="/shuang11/dqstatic/css/ant_special_20191101.css" rel="stylesheet" type="text/css">


<div class="special-house-electrical" style="background:#5f110b">
        <!--banner start-->
        <div class="special-house-electrical-banner">
            <img src="/shuang11/dqstatic/images/banner.jpg">
        </div>
        <!--banner end-->
        <div class="special-house-electrical-con">
            <!--part1 start-->
           <div class="special-house-electrical-tit">
            品质家电特价专区
           </div>
           <div class="special-house-electrical-part1">
              <ul>
                 <?php foreach($goods as $key=>$goodsVal):?>
                   <?php if($key<2):?>
                <li  class="clearfix">
                   <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>">
                      <div class="li-shadow"></div>
                      <div class="div-con clearfix">
                        <div class="h-e-l">
                            <em></em>
                            <img src="<?=$goodsVal["goods_thums"]?>">
                        </div>
                        <div class="h-e-r">
                            <h2><?=$goodsVal["goods_name"]?></h2>
                            <p class="p01 text-overflow"><?=$goodsVal["desc"]?></p>
                            <p class="p02">
                              <span class="money"><em>￥</em><?=$goodsVal["price"]?></span>
                              <span class="money-l">￥<?=$goodsVal["old_price"]?></span>
                              <button class="btn-01">立即抢购</button>
                            </p>
                        </div>
                      </div>
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
           <div class="special-house-electrical-tit">
            品味家电  乐享商城<em></em>
           </div>
           <div class="special-house-electrical-part2 clearfix">
               <ul  class="clearfix">
                  <?php foreach($goods as $key=>$goodsVal2):?>
                   <?php if($key>1):?>
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