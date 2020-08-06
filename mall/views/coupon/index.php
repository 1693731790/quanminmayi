<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="我的优惠券";
?>
<style type="text/css">
  .CouponCenter .CouponTab ul li {width:50%;}
</style>

<div class="Head88 pt88">
    <header class="TopGd"> <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>
        <h2>优惠券</h2>
    </header>
    <div class="CouponCenter">
        <div class="CouponTab">
            <ul class="clearfix">
                <li <?=$type==""?'class="on"':''?> ><span><a href="<?=Url::to(['coupon/index'])?>">全部</a></span></li>
                <li <?=$type=="1"?'class="on"':''?>><span><a href="<?=Url::to(['coupon/index','type'=>1])?>">已过期</a></span></li>
            </ul>
        </div>
        <div class="CouponList">
            <ul id="list_box">
                <?php foreach($coupon as $couponVal):?>
                <li <?=$couponVal->end_time<time()?"class='on'":''?> >
                    <div class="item radius-15">
                        <div class="bt clearfix">
                            <p class="num fl"><i>￥</i><?=$couponVal->fee?></p>
                            <div class="txt fl">
                                <p>优惠券</p>
                             </div>
                            <div class="round"></div>
                            <div class="btn">
                              <?php if($couponVal->end_time<time()):?>
                                  已过期
                              <?php else:?>
                                  <a href="<?=Url::to(["shops/shop-info",'shop_id'=>$couponVal->shops->shop_id])?>">去使用</a>
                              <?php endif;?>
                            </div>
                        </div>
                        <div class="desc">
                            <p>有效期：<?=date("Y-m-d H:i:s",$couponVal->end_time)?></p>
                            <p>店铺：<?=$couponVal->shops->name?></p>
                        </div>
                    </div>
                </li>
                <?php endforeach;?>
                
                
            </ul>
        </div>
    </div>
</div>

<script>
var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['coupon/coupon-list'])?>",{"page":page,"type":"<?=$type?>"},function(da){
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