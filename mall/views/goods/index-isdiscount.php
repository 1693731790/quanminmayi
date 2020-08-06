<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="特价";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/tejiashopping.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />


<?php if(empty($_GET["token"])):?>
<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>
<?php endif;?>
<div class="beiji"><img class="pico" src="/webstatic/images/tejiaguan4-10_01.png"/></div>
<div id="content">  
    <div class="tout">
        <div class="toutu">
        特价商品
        </div>
    </div>
    <div class="tab_css" id="tab1_content" style="display:block">  
      <?php foreach($goods as $key=>$goodsVal):?>
        <div class="pageone">
          <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>">
          <div class="leftpic">
           <img class="leftpict" src="<?=$goodsVal["goods_thums"]?>"/> 
          </div>
          <div class="rightwenzi">
              <div class="rightwenzione"><?=$goodsVal["goods_name"]?></div>
              <div class="rightwenzitwo"><?=$goodsVal["desc"]?></div>
              <div class="rightwenzithree">¥<?=$goodsVal["price"]?><span class="price">¥<?=$goodsVal["old_price"]?></span></div>
              <div class="rightwenzifour"><div class="righttitle">已购买<?=$goodsVal["salecount"]?>件</div>
                  
                  <div class="righttitlethree">立即抢购</div>
              </div>

          </div>
        </a>
        </div> 
        <?php endforeach;?>
    </div>   
</div>  



    



<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['goods/goods-list'])?>",{"page":page,"isdiscount":"<?=$isdiscount?>"},function(da){
             $('#tab1_content').append(da);                                      
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
