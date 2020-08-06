<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="用户中心";
?>
<style>
  .shouhuoo li{ text-align: center;}
  .shouhuo li{ text-align: center;}

        .allAnt-set{ position: absolute;top:0.8rem;right:0.8rem;width:1.2rem; height:1.2rem; z-index: 1000000;}
        .allAnt-set a{text-decoration: none;outline: none;}
        .allAnt-set img{width:100%;}
</style>
<link rel="stylesheet" type="text/css" href="/webstatic/css/reset_m.css"> 
    <link rel="stylesheet" type="text/css" href="/webstatic/css/gerenzhongxin.css">
    <link rel="stylesheet" type="text/css" href="/webstatic/css/font-size/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/webstatic/css/index/iconfont.css" /> 
<div class="head-big">
<div class="headbody">
<img class="shop-search" src="/webstatic/images/bja_02.jpg"/>
</div>
  <div class="allAnt-set"><a href="<?=Url::to(["user/set"])?>"><img src="/newstatic/images/nav_setting.png"/></a></div>
<div class="news">
<div class="name">
<div class="touxiang"><img class="shops" src="<?=$headimgurl?>"/></div>
<!--<div class="touxiang"><img class="shops" src="/webstatic/images/touxiang_03.jpg"/></div>-->
  
<div style="font-size:0.7rem;text-align: center; margin-top:0.5rem;">
    <?=$nickname?>  
   <a href="<?=Url::to(["user/user-info"])?>"><img style="display: inline-block;" src="/webstatic/images/one (15).png"/></a>
</div>
<?php if($is_upgrade=="1"):?>
<div class="twotname">vip会员</div>
<?php endif;?>
<!--<div class="threename"><img class="shop" src="/webstatic/images/one (15).png"/></div>-->
</div>


  

<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')):?>

 <!--
<div class="statement">
  <div class="statementleft">话费余额:&nbsp&nbsp<span class="statementred"><?=$callFee?></span></div>
  <div class="statementright"><a style="color:#fc3b3e" href="<?=Url::to(["user/recharge"])?>">充值 </a></div>
</div>

<div class="balances">
  <div class="balancesleft">我的佣金<br><span class="mybalances"><?=round($wallet+$waitWallet,2)==0?round($wallet+$waitWallet,2).".00":round($wallet+$waitWallet,2)?></span></div>
  
  <a href="<?=Url::to(["wallet/wallet-info"])?>" style="display:block"><div class="balancesright">可提收益<br><span class="myshouyi"><?=$wallet?></span></div></a>
  <div class="balancescirle"></div>
  
  <a href="<?=Url::to(["wallet/wait-wallet-info"])?>" style="display:block"><div class="balancescenter">搬运中收益<br><span class="mycenter"><?=$waitWallet?></span></div></a>
  
  <div class="balancescirles"></div>
</div>-->
<?php else:?>
  <div class="statement">
  <div class="statementleft">话费余额:&nbsp&nbsp<span class="statementred"><?=$callFee?></span></div>
  <div class="statementright"><a style="color:#fc3b3e" href="<?=Url::to(["user/recharge"])?>">充值 </a></div>
</div>

<div class="balances">
  <div class="balancesleft">我的佣金<br><span class="mybalances"><?=round($wallet+$waitWallet,2)==0?round($wallet+$waitWallet,2).".00":round($wallet+$waitWallet,2)?></span></div>
  
  <a href="<?=Url::to(["wallet/wallet-info"])?>" style="display:block"><div class="balancesright">可提收益<br><span class="myshouyi"><?=$wallet?></span></div></a>
  <div class="balancescirle"></div>
  
  <a href="<?=Url::to(["wallet/wait-wallet-info"])?>" style="display:block"><div class="balancescenter">搬运中收益<br><span class="mycenter"><?=$waitWallet?></span></div></a>
  
  <div class="balancescirles"></div>
</div>
<?php endif;?> 
</div>

<div class="twobody">
<div class="myorder">
<div class="myorderone"></div><div class="myordertwo">我的订单</div><div class="myorderthree"><a style="color:#a0a0a0;" href="<?=Url::to(["user/order"])?>">查看全部订单></a></div>
</div>
<div class="shouhuo">
<ul>
    <li><a href="<?=Url::to(["user/order","status"=>0])?>">
    <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (1).png"/></div>
      <div class="pio">待付款</div></a>
    </li>
    <li> <a href="<?=Url::to(["user/order","status"=>1])?>"><div class="pim" align="center"><img class="shop" src="/webstatic/images/one (3).png"/></div>
    <div class="pio">待发货</div></a></li>
    <li> <a href="<?=Url::to(["user/order","status"=>2])?>"><div class="pim" align="center"><img class="shop" src="/webstatic/images/one (5).png"/></div>
    <div class="pio">待收货</div></a></li>
    <li> <a href="<?=Url::to(["user/order","status"=>3])?>"><div class="pim" align="center"><img class="shop" src="/webstatic/images/one (7).png"/></div>
    <div class="pio">已完成</div></a></li>
    <li><a href="<?=Url::to(["user/order","status"=>4])?>">
    <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (4).png"/></div>
    <div class="pio">退款</div></a>
    </li>
    </ul>
</div>
</div>
<div class="threebody">
<div class="myorder">
<div class="myorderone"></div><div class="myordertwo">我的工具栏</div>
</div>
<div class="shouhuoo">
<ul>
    <!--<li> <a href="<?=Url::to(["order-seckill/order"])?>">
    <div class="pim" align="center"><img class="shop" src="/webstatic/images/seckill_order.png"/></div>
    <div class="pio">秒杀订单</div></a>
    </li>-->
    <li>
     <a href="<?=Url::to(["signin-log/index"])?>"><div class="pim" align="center"><img class="shop" src="/webstatic/images/one (6).png"/></div>
      <div class="pio">签到</div></a>
    </li>
    <li> <a href="<?=Url::to(["message/index"])?>"> <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (11).png"/></div>
    <div class="pio">消息</div></a></li>
    <li> <a href="<?=Url::to(["favorite/goods-favorite"])?>"> <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (10).png"/></div>
    <div class="pio">我的收藏</div></a></li>
    <li> <a href="<?=Url::to(["favorite/shops-favorite"])?>"> <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (9).png"/></div>
    <div class="pio">关注的店铺</div></a></li>
    <li>
     <a href="<?=Url::to(["user/address-list"])?>"><div class="pim" align="center"><img class="shop" src="/webstatic/images/one (22).png"/></div>
    <div class="pio">地址管理</div></a>
    </li>
    
    <li> <a href="<?=Url::to(["coupon/index"])?>">
    <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (13).png"/></div>
    <div class="pio">优惠券</div></a>
    </li>
    <li> <a href="<?=Url::to(["user/about"])?>"> <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (2).png"/></div>
    <div class="pio">关于我们</div></a></li>
    <li> <a href="<?=Url::to(["user-feedback/index"])?>"> <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (12).png"/></div>
    <div class="pio">用户反馈</div></a></li>
  <?PHP if(Yii::$app->user->identity->id==633):?>
  	<li> <a href="<?=Url::to(["user/recharge-card"])?>"> <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (12).png"/></div>
    <div class="pio">账户充值</div></a></li>
    <li> <a href="<?=Url::to(["phone/index"])?>"> <div class="pim" align="center"><img class="shop" src="/webstatic/images/one (12).png"/></div>
    <div class="pio">用户反馈</div></a></li>
  <?php endif;?>
    </ul>
</div>
</div>
</div>


 