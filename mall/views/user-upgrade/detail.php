<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title=$model->goods_name;
?>
 <link rel="stylesheet" href="/newstatic/css/style.css">
<style type="text/css">
  .addorder{    height: 1.5rem;
    width: 80%;
    background:#e43838;
    border-radius: 1.5rem;
    color: #fff;
    font-size: 0.6rem;
    text-align: center;
    line-height: 1.5rem;
    position: fixed;
    bottom: 2%;
    left: 10%;}
</style>
  <body>
    <?php if(empty($_GET["token"])):?>

   <header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>会员大礼包
</header>
    <?php endif;?>
      <div class="index-banner">
    <ul class="banner-inner">
      <?php if($model->goods_img!=""):?>
        <?php for($ii=0;$ii<count($model->goods_img);$ii++):?>
            
            <li class="first" style="background:#aac7f3 url(<?=Yii::$app->params['imgurl'].$model->goods_img[$ii]?>) center center no-repeat;background-size: cover;">
          </li>
        <?php endfor;?>
      <?php else:?>
          <li class="first" style="background:#aac7f3 url(<?=Yii::$app->params['imgurl'].$model->goods_thums?>) center center no-repeat;background-size: cover;">
          </li>
      <?php endif;?>
        
     
    </ul>
</div>
<div class="titleq">
     <?=$model->goods_name?>
      <br>
       <div class="titlet">
      会员专享
      </div>
     <div class="price">¥<?=$model->price?>&nbsp<span class="haha">¥<?=$model->old_price?></span></div> 
</div>
    <div class="moda" style="height:auto;">
      <div class="nava"></div>
 <style type="text/css">
       p{margin-left: 0.5rem;}
   .piclibao img{width:100%;
    display:block;
   }
 </style>     
     <div class="piclibao" ><?=$model->content?></div>
     
<form id="orderform" action="<?=Url::to(['goods/add-order'])?>" method="post">
  <input type="hidden" name="goods_id" value="<?=$model->goods_id?>">
  <input type="hidden" name="shop_id" value="<?=$model->shop_id?>">
  <input type="hidden" name="skuPath" value="">
  <input type="hidden" id="text_box" name="goodsnum"  value="1" />   
     <!-- <a href="javascript:;"> <div  class="btnn addorder" id="btnn" >立即购买</div></a> -->
  <a href="javascript:;"> <div  class="addorder"  >立即购买</div></a> 

  

</form>
      <!-- <a href="login.html"> <div  class="btnn" id="btnn" >立即购买</div></a>  -->
    </div>
 </div>

  <script type="text/javascript" src="js/rili.js">
  </script><script type="text/javascript" src="js/jquery1.72.min.js"></script>
  
  <script src="/newstatic/js/jquery.edslider.js"></script>
  <script>
$(".addorder").click(function(){
      
      
          $("#orderform").submit();  
      
      
})

$("#btnn").css("bottom",0);
$("#btnn").css("position","fixed");


  (function (doc, win) {
          var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
              var clientWidth = docEl.clientWidth;
              if (!clientWidth) return;
              docEl.style.fontSize = 20 * (clientWidth / 320) + 'px';
            };


          if (!doc.addEventListener) return;
          win.addEventListener(resizeEvt, recalc, false);
          doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
  </script>
  </body>
</html>
