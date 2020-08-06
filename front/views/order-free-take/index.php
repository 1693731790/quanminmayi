<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '免费拿';
?>

    <link rel="stylesheet" type="text/css" href="/webstatic/css/mianfei.css">
    <link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />
<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>
<div class="header"><img class="shop-search" src="/webstatic/images/bjcolor_01.jpg"/></div>

<div id="list_box">
<?php foreach($model as $key=>$val):?>
<div class="centers">
  <div class="centerone"><img class="centertwos" src="<?=$val->goods_thums?>"/></div>
  <div class="centertwo">
    <div class="centertwoone"><?=$val->goods_name?></div>
    <div class="centertwotwo">需<?=$val->user_num?>人助力</div>
    <div class="centertwothree">
      <div class="centertwothrees"><?=$val->get_user_num?>人已助力</div>
      <div class="centertwothreea"><a style="color:#fff" href="<?=Url::to(["order-free-take/detail","order_id"=>$val->order_id])?>">分享</a></div>
     
    </div>
  </div>
</div>
<?php endforeach;?>







  <div class="bobbom-btn"><a href="<?=Url::to(["share-free/index"])?>"> <div class="bobbom-left">免费拿频道</div></a><a href="javascript:;"> <div class="bobbom-right">我的免单</div></a></div>


<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['order-free-take/list'])?>",{"page":page},function(da){
             $('#list_box').append(da);                                      
    })
   
    off_on = true; //[重要]这是使用了 {滚动加载方法1}  时 用到的 ！！！[如果用  滚动加载方法1 时：off_on 在这里不设 true的话， 下次就没法加载了哦！]
};
$(".bobbom-left").click(function () {
$(".bobbom-left").css("color", "#fc3b3e"); 
})

$(".bobbom-right").click(function () {
$(".bobbom-right").css("color", "#fc3b3e"); 
})
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
