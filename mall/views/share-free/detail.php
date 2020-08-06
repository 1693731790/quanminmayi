<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title ="商品详情";
?>
<style type="text/css">
.PurchaseOperation .left li {width: 50%;}
.coupon{font-size: 0.6rem;height: 1rem;line-height: 1rem;color: #ff5c36;padding: 0 0.5rem;border: 1px solid #f84e37;border-radius:5px;margin-top: 5px;}
.contentimg img{width:100%;}
  table tr td{border:0}

img  
{  
  display: block;
  width:100%;
  height:100%;
  outline-width:0px;  
  vertical-align:top;  
}
.img-adventure{
  margin-bottom:12%;
}
p#back-to-top{
     position: fixed;
    display: none;
    bottom: 3rem;
    right: 1rem;
}
</style>

<link rel="stylesheet" type="text/css" href="/webstatic/css/particularspage.css">
<header>

        <a href="javascript:;" onclick="javascript:history.go(-1)"><div class="_lefte"><img class="shopp" src="/webstatic/images/nva_03.png"/></div></a>
      
</header>
<p id="back-to-top"><a href="#top"><img class="widgh-img" src="/webstatic/images/fanhuidingbu.png"/></a></p>
<div class="outer">
 <div class="index-banner">
    <ul class=" swiper-wrapper" >
        <?php if($model->goods_img!=""):?>
        <?php for($ii=0;$ii<count($model->goods_img);$ii++):?>
            <li class="first swiper-slide"><img class="img-s" src="<?=Yii::$app->params['imgurl'].$model->goods_img[$ii]?>"/></li>
        <?php endfor;?>
        <?php else:?>
            <li class="first swiper-slide"><img class="img-s" src="<?=Yii::$app->params['imgurl'].$model->goods_thums?>"/></li>
            
        <?php endif;?>  
        
     <div class="swiper-pagination3 tc"></div>
    </ul>
    <script>
      $(window).load(function(){
        var mySwiper = new Swiper('.index-banner', {
        autoplay: 3000,//可选选项，自动滑动
        pagination : '.swiper-pagination3',
        loop : true,
        autoplayDisableOnInteraction : false
        })
      }) 
    </script> 
 </div>
  <div class="color-say"></div>
  <div class="outertwo">
    <div class="outertwoone">
      <div class="outertwooneq" style="width:90%;line-height: 1.5rem"><?=$model->goods_name?></div>
     
    </div>
    <div class="outertwotwo"><span class="haha">¥<?=$model->old_price?></span></div>
    <div class="outertwofour">
      <div class="outertwofourone">销量：&nbsp<?=$model->salecount?><span class="outertwofourtwo"></span></div>
    </div>
    
  </div>
        <div class="new-img"></div>
 <div class="left_new">
  <div class="left-left"><img class="pi-im" src="/webstatic/images/leftjiantou_07.png"/></div>
  <div class="left-right">上拉查看商品详情</div>
 </div>
 <div class="img-adventure" style="margin-bottom: 3rem">
  <?=$model->content?>
 </div>
  
</div>


<div class="PurchaseOperation gd">
  
  <div class="right fr" style="width:100%">
    
    <button type="button" class="but bg_ff5c36 addorder" style="width:100%">立即购买</button>
  </div>
</div>



<!--弹窗-->

<script type="text/javascript">
$(function(){
 

  $(".addorder").click(function(){
      
          $("#orderform").submit();  
      
      
  })
 

})
  
</script>
<form id="orderform" action="<?=Url::to(['share-free/add-order'])?>" method="post">
  <input type="hidden" name="goods_id" value="<?=$model->goods_id?>">
    
  
</form>
  



<script>

$(function(){
  $("table").width(0);
})
/*返回顶部*/
$(function(){
        //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
        $(function () {
            $(window).scroll(function(){
                if ($(window).scrollTop()>100){
                    $("#back-to-top").fadeIn(1500);
                }
                else
                {
                    $("#back-to-top").fadeOut(1500);
                }
            });
 
            //当点击跳转链接后，回到页面顶部位置
            $("#back-to-top").click(function(){
                if ($('html').scrollTop()) {
                    $('html').animate({ scrollTop: 0 }, 100);//动画效果
                    return false;
                }
                $('body').animate({ scrollTop: 0 }, 100);
                return false;
            });
        });
    });
</script>