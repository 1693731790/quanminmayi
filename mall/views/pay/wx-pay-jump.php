<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="订单支付";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/zhifususses.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />


<div class="outer">
<div class="outerone"><img class="pic" src="/webstatic/images/susses1_03.jpg"/></div>
<div class="outertwo">订单支付</div>
<!--<div class="outerfour"><div class="outerfourone"><a href="<?=Url::to(["user/order"])?>" style="color:#fff">我已支付</a></div><div class="outerfourtwo"><a href="<?=Url::to(["index/index"])?>" style="color:#fc3b3e">返回首页</a></div></div>-->
</div>



<script type="text/javascript">
 	function onBridgeReady(){
     WeixinJSBridge.invoke(
         'getBrandWCPayRequest', {
         "appId":"<?=$data["appId"]?>",     //公众号名称，由商户传入     
         "timeStamp":"<?=$data["timeStamp"]?>",         //时间戳，自1970年以来的秒数     
         "nonceStr":"<?=$data["nonceStr"]?>", //随机串     
         "package":"<?=$data["package"]?>",     
         "signType":"MD5",         //微信签名方式：     
         "paySign":"<?=$data["paySign"]?>" //微信签名 
      },
      function(res){
      if(res.err_msg == "get_brand_wcpay_request:ok" ){
      		window.location.href="<?=Url::to(["user/order"])?>";
      } 
   }); 
}
if (typeof WeixinJSBridge == "undefined"){
   if( document.addEventListener ){
       document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
   }else if (document.attachEvent){
       document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
       document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
   }
}else{
   onBridgeReady();
}
 </script> 