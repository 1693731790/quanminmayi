<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="精选商品";
?>

<link rel="stylesheet" type="text/css" href="/webstatic/css/zaochunchuyou.css">
<!-- <link rel="stylesheet" type="text/css" href="css/iconfont/iconfont.css" /> -->
<link rel="stylesheet" type="text/css" href="css/fontsizes/iconfont.css" />
<?php if(empty($_GET["token"])):?>

<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="is" src="/webstatic/images/black-img.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>
<?php endif;?>
<div class="header"><img class="centertwos" src="/webstatic/images/chunjiimgF_01.png"/></div>
<div class="headerout"><img class="centertwo" src="/webstatic/images/jinx-sp_04.png"/></div>
<div class="headeroutone">
<ul id="list_box">
   <?php foreach($goods as $key=>$goodsVal):?>
    <li>
      <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>">
        <div class="spa">
            <img class="picee" src="<?=$goodsVal["goods_thums"]?>">
                <div class="titlewee">
                    <?=$goodsVal["goods_name"]?>
                    <div class="pricee">¥<?=$goodsVal["price"]?>&nbsp<span class="hahae">¥<?=$goodsVal["old_price"]?></span></div>
                    <div class="shopedsi"><?=$goodsVal["salecount"]?>人已买</div>
                </div> 
        </div>
      </a>
    </li>
    <?php endforeach;?>
</ul>

</div>



    



<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['goods/goods-list'])?>",{"page":page,"isselected":"<?=$isselected?>"},function(da){
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
