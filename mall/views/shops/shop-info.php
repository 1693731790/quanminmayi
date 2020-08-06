<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title =$shop->name;
?>
<style type="text/css">
  header .SearchBox3 .InputBor { width: 13.1rem;}
  header .SearchBox .icon-search {right: -40px;}
</style>

<div class="Web_Box">
  <div class="ShopIndex">
    <i class="TransparentBut TransparentReturn iconfont icon-leftdot" onClick="history.go(-1)"></i>
  
    <div class="ShopHead xd">
      <div class="con">
        <h1 class="slh"><?=$shop->name?></h1>
       </div>
      <div class="Photo"><img src="<?=$shop->img!=""?Yii::$app->params['imgurl'].$shop->img:'/static/images/photo.png'?>" alt=""></div>
      <div class="ShopSfy">
        <i class="iconfont icon-flagshipstore mr25"></i>
       <!--  <i class="iconfont icon-heart"></i>
        <i class="iconfont icon-heart"></i>
        <i class="iconfont icon-heart"></i>
        <i class="iconfont icon-heart"></i>
        <i class="iconfont icon-heart"></i> -->
      </div>
      <div class="OtherInfo">
        <ul>
          <li class="w161" onclick="screening(0)">
            <p class="num"><?=$count?></p>
            <p class="text">全部宝贝</p>
          </li>
          <li class="w161" onclick="screening(2)">
            <p class="num"><?=$newcount?></p>
            <p class="text">新品</p>
          </li>
          <li class="w161" onclick="screening(1)">
            <p class="num"><?=$tuijiancount?></p>
            <p class="text">推荐商品</p>
          </li>
          <li class="w88" style="width: 3.2rem;" onclick="screening(3)">
            <p class="num"><?=$hotcount?></p>
            <p class="text">热卖商品</p>
          </li>
        </ul>
      </div>
      <!-- <div class="follow">+关注</div> -->
    </div>
    <div class="ProList2 bg_fff mt20">
      <div class="tit">
        <h1><?php 
         
            if($istuijian=="1")
            {
                echo "推荐商品";
            }else if($isnew=="1")
            {
                echo "新品";
            }else if($ishot=="1")
            {
                echo "热卖商品";
            }else{
                echo "全部商品";
            }
        ?>(<?=$count?>)</h1>
      </div>
      <div class="con">
        <ul id="list_box">
          <?php foreach($goods as $goodskey=>$goodsval):?>
          <li>
            <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsval['goods_id']])?>">
              <div class="pic"> <img src="<?=Yii::$app->params['imgurl'].$goodsval['goods_thums']?>" alt=""/> </div>
              <h3 class="slh2"><?=$goodsval['goods_name']?></h3>
              <p class="Price">￥<?=$goodsval['price']?><span class="OriginalPrice">￥<?=$goodsval['old_price']?></span></p>
              
            </a>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div> 
  </div>  
</div>


<script type="text/javascript">
  function screening(type){
   
    var url;
    if(type==1)
    {
      url="<?=Url::to(['shops/shop-info','shop_id'=>$shop_id,"istuijian"=>"1"])?>";
    }else if(type==2)
    {
      url="<?=Url::to(['shops/shop-info','shop_id'=>$shop_id,"isnew"=>"1"])?>";
    }else if(type==3){
      url="<?=Url::to(['shops/shop-info','shop_id'=>$shop_id,"ishot"=>"1"])?>";
    }else{
      url="<?=Url::to(['shops/shop-info','shop_id'=>$shop_id])?>";
    }

    window.location.href=url;
  }

</script>
<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据 
 function LoadingDataFn() {
    $.get("<?=Url::to(['shops/goods-list'])?>",{"page":page,"shop_id":"<?=$shop_id?>","istuijian":"<?=$istuijian?>","isnew":"<?=$isnew?>","ishot":"<?=$ishot?>"},function(da){
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