<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="数码馆";
?>
<style type="text/css">
  .headerwenzi{overflow: hidden;}
</style>
<link rel="stylesheet" type="text/css" href="/webstatic/css/shumaguan.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/font/iconfont.css" />
<!-- <header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><i class="iconfont icon-back is"></i></div></a>
</header> -->
<?php if(empty($_GET["token"])):?>

<header>
        <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>
<?php endif;?>
 <div class="header"><img class="shop-s" src="/webstatic/images/haederbeijing_01_add.jpg"/></div>
<div class="outer">
    <div class="headerone"><img class="shop-sq" src="/webstatic/images/toutiao_14.jpg"/></div> 
    <div id="list_box">
    <?php foreach($goods as $key=>$goodsVal):?>
      <?php if($key%2==0):?>
    <div class="headertwo">
        <div class="headertwoone"><img class="shop-so" src="<?=$goodsVal["goods_thums"]?>"/></div>
        <div class="headertwotwo">
        <div class="headerwenzi"><?=$goodsVal["goods_name"]?></div>
        <div class="headerprice">促销价:&nbsp<span class="price"><?=$goodsVal["price"]?></span>元</div>
        <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>"><div class="headerbuy">立即购买</div></a>
        </div>
    </div>
    <?php else:?>
    <div class="headerthree">
        <div class="headerthreetwo">
        <div class="headerwenzi"><?=$goodsVal["goods_name"]?></div>
        <div class="headerprice">促销价:&nbsp<span class="price"><?=$goodsVal["price"]?></span>元</div>
         <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>"><div class="headerbuy">立即购买</div></a>
        </div>
        <div class="headerthreeone"><img class="shop-so" src="<?=$goodsVal["goods_thums"]?>"/></div>
    </div>
   <?php endif;?>
   <?php endforeach;?>
  </div>

</div>



    



<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['goods/goods-list'])?>",{"page":page,"isdigital":"<?=$isdigital?>"},function(da){
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
