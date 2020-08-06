<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="秒杀专区";
?>

<style type="text/css">
  .SecondKill{padding-top: 0px;}
  .SecondKillList ul li .title{height: 0.75rem;}
  .SecondKillList ul li .skill-count {height: 0.8rem;line-height: 0.8rem;}
</style>

<div class="Head88 pt88">
  <header class="TopGd"> <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>
    <h2>秒杀专区</h2>
  </header>
  <div class="SecondKill">
    
    
    <div class="SecondKillList mt18">
      <ul id="list_box">
        <?php foreach($robgoods as $robgoodsVal):?>
        <li>
          <a href="<?=Url::to(["rob-buy/detail","rob_id"=>$robgoodsVal->rob_id])?>" class="clearfix">
            <div class="pic fl" style="background-image:url(<?=Yii::$app->params['imgurl'].$robgoodsVal->goods->goods_thums?>)"></div>
            <div class="text">
              <h2 class="title slh2"><?=$robgoodsVal->goods->goods_name?></h2>

              <p class="price">秒杀价<span class="num">￥<?=$robgoodsVal->price?></span><span class="OriginalPrice">￥<?=$robgoodsVal->goods->price?></span></p>
              <p class="price">开始时间 <span class="num"><?=date("Y-m-d H:i",$robgoodsVal->start_time)?></span></p>
              <p class="price">结束时间 <span class="num"><?=date("Y-m-d H:i",$robgoodsVal->end_time)?></span></p>
              

              <div class="skill-count clearfix radius-3"><span class="surplus fl">剩余<?=$robgoodsVal->num?>件</span></div>

            </div>
          </a>
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
    $.get("<?=Url::to(['rob-buy/rob-buy-list'])?>",{"page":page},function(da){
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