<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="我的店铺";
?>

<div class="Web_Box">
  <div class="OpenShopHead xd">
    <div class="Photo"><img src="<?=Yii::$app->params['imgurl'].$shop->img?>" alt=""/></div>
    <div class="con">
      <h1><?=$shop->name?></h1>
      <div class="AddressBox"> <span class="text"><?=$shop->desc?></span> </div>
    </div>
   <!--  <div class="PreviewEntry"> <a href="http://www.qq.com" class="disb"> <i class="iconfont icon-preview"></i> </a> </div> -->
  </div>
  
  <!--数据统计Start-->
  <div class="DataStatistics bor_b_dcdddd">
    <div class="con bor_b_dcdddd">
      <ul>
        <li><span class="left_text">可提现总金额（元）：</span> <span class="right_text cr_f84e37">￥<?=$balance?></span> </li>
        <li><span class="left_text">累计总收入（元）：</span> <span class="right_text cr_f84e37">￥<?=$countFee?></span> </li>
        <li><span class="left_text">本月收入（元）：</span> <span class="right_text cr_f84e37"><?=$mFee?></span> </li>
        <li><span class="left_text">待处理订单：</span> <span class="right_text cr_f84e37"><?=$untreatedOrder?></span> </li>
      </ul>
    </div>
    <div class="OtherInfo hidden tc">
      <ul>
        <li>
          <p class="num"><?=$countOrder?></p>
          <p class="text">总订单量</p>
        </li>
        <li>
          <p class="num"><?=$mOrder?></p>
          <p class="text">本月销量</p>
        </li>
        <li>
          <p class="num"><?=$shop->browse?></p>
          <p class="text">访客</p>
        </li>
      </ul>
    </div>
  </div>
  <!--数据统计End--> 
  
  <!--操作入口Start-->
  <div class="OperationEntry mt25">
    
    <div class="con hidden mb25 bor_b_dcdddd">
      <ul>
        <li>
          <a href="<?=Url::to(['my-shop/withdraw-cash-create'])?>">
            <i class="iconfont icon-commissionpresent cr_ff0b95"></i>
            <p>提现</p>
          </a>
        </li>
        <li>
          <a href="<?=Url::to(['my-shop/goods'])?>">
            <i class="iconfont icon-commoditymanagement cr_edb800"></i>
            <p>商品管理</p>
          </a>
        </li>
        <li>
          <a href="<?=Url::to(['my-shop/order'])?>">
            <i class="iconfont icon-allorders cr_fc560d"></i>
            <p>订单管理</p>
          </a>
        </li>
       <li>
          <a href="<?=Url::to(['user-bank/bank-list'])?>">
            <i class="iconfont icon-bankcard cr_f78d1b"></i>
            <p>银行卡</p>
          </a>
        </li>
        <li>
          <a href="<?=Url::to(['my-shop/wallet'])?>">
            <i class="iconfont icon-bankcard cr_f78d1b" style="color:#18a55e"></i>
            <p>钱包记录</p>
          </a>
        </li>
        <li>
          <a href="<?=Url::to(['my-shop/withdraw-cash'])?>">
            <i class="iconfont icon-bankcard cr_f78d1b" style="color:#6459f1"></i>
            <p>提现记录</p>
          </a>
        </li>
        
          
        
      </ul>
    </div>
  </div>
  <!--操作入口End--> 
  
  <!--广告轮播Start-->
 <!--  <div class="mb25">
    <div class="Advertisement2 swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="/static/images/ads2.png" alt=""/></div>
        <div class="swiper-slide"><img src="/static/images/ads2.png" alt=""/></div>
        <div class="swiper-slide"><img src="/static/images/ads2.png" alt=""/></div>
        <div class="swiper-slide"><img src="/static/images/ads2.png" alt=""/></div>
      </div>
      <div class="swiper-pagination2 tc"></div>
    </div>
  </div> -->
  <script>
  $(window).load(function(){
    var mySwiper = new Swiper('.swiper-container', {
    autoplay: 3000,//可选选项，自动滑动
    pagination : '.swiper-pagination2',
    loop : true,
    autoplayDisableOnInteraction : false
    })
    }) 
  
  </script> 
  <!--广告轮播End--> 
  
</div>
