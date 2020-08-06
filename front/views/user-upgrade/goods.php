<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title="会员大礼包";
?>
<link rel="stylesheet" href="/newstatic/css/gifts.css" />

  <body>
<?php if(empty($_GET["token"])):?>
<header>
    <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>会员大礼包
</header>
<?php endif;?>       

      <div class="heads">
      </div>
      <div class="title">
      <div class="titles"></div>
   
   <?php foreach($goods as $goodsVal):?>
       
   <div class="giftc">
    <a href="<?=Url::to(["user-upgrade/detail","goods_id"=>$goodsVal->goods_id])?>">
      <img  class="picq" src="<?=Yii::$app->params['imgurl'].$goodsVal->goods_thums?>">  
      <div class="titlei">
        <?=$goodsVal->goods_name?>
        <div class="titlet">

        会员专享
        </div>
        <div class="price">¥<?=$goodsVal->price?>&nbsp<span class="haha">¥<?=$goodsVal->old_price?></span></div>
        <button class="btn" type="button">立即购买</button>
      </div>
      </a>
   </div>
  <?php endforeach;?>
        
   <!-- <div class="difte">
    <div class="titlez">
     <p>1、&nbsp购买就送精美包装，方便送礼;</p>
    <p>2、&nbsp会员大礼包</p>
    <p>3、&nbsp自助购物送明信片一套和小礼品</p>
     <p>4、&nbsp购物就送精美包装，方便送礼;</p>
     <p>5、&nbsp会员礼包</p>
    </div>
      </div> -->
      <div class="dibu">
      <div class="wenzi">
      <div class="one">1、&nbsp购买就送精美包装，方便送礼;</div>
    <div class="one">2、&nbsp会员大礼包</div>
    <div class="one">3、&nbsp自助购物送明信片一套和小礼品</div>
     <div class="one">4、&nbsp购物就送精美包装，方便送礼;</div>
     <div class="one">5、&nbsp会员礼包</div>
     </div>
      </div>

  <script type="text/javascript" src="/newstatic/js/rili.js">
  </script><script type="text/javascript" src="/newstatic/js/jquery1.72.min.js"></script>
  
  <script>
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



<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['user-upgrade/goods-list'])?>",{"page":page,"salecount":"<?=$salecount?>","browse":"<?=$browse?>","new":"<?=$new?>","searchKey":"<?=$searchKey?>","istodaynew":"<?=$istodaynew?>"},function(da){
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