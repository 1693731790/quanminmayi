<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="京东卖场";
?>

<link rel="stylesheet" type="text/css" href="/webstatic/css/jingdongsell.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />
<?php if(empty($_GET["token"])):?>

<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>
<?php endif;?>
<div class="outer"><img class="picq" src="/webstatic/images/beiji_01_add.jpg"/></div>
<div class="outerone">爆款热销</div>
<div class="centers">
  <div class="centerone"><img class="centertwos" src="<?=$goods[0]["goods_thums"]?>"/></div>
  <div class="centertwo">
    <div class="centertwoone"><?=$goods[0]["goods_name"]?></div>
    <div class="centertwotwo"><?=$goods[0]["desc"]?></div>
    <div class="centertwothree"><div class="centertwothrees">¥<?=$goods[0]["price"]?>&nbsp<span class="haha">¥<?=$goods[0]["old_price"]?></span></div></div>
     <a href="<?=Url::to(["goods/detail","goods_id"=>$goods[0]["goods_id"]])?>"><div class="centertwofour">立即购买</div></a>
  </div>
</div>
<div class="pil">
  <ul id="list_box">
    <?php foreach($goods as $goodsKey=>$goodsVal):?>
      <?php if($goodsKey>0):?>
    <li>
      <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>">
      <div class="pilone">
        <div class="piloneone"><img class="pui" src="<?=$goodsVal['goods_thums']?>"/></div>
        <div class="pilonetwo">￥<?=$goodsVal['price']?></div>
        
        <div class="pilonethree">立即购买</div>
      </div>
    </a>
    </li>
  <?php endif;?>
    <?php endforeach;?>
  </ul>

</div> 
    
    



<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['goods/goods-list'])?>",{"page":page,"isjd":"<?=$isjd?>"},function(da){
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
