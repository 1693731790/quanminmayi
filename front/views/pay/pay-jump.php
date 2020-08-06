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
<div class="outerfour"><div class="outerfourone"><a href="<?=Url::to(["user/order"])?>" style="color:#fff">我已支付</a></div><div class="outerfourtwo"><a href="<?=Url::to(["index/index"])?>" style="color:#fc3b3e">返回首页</a></div></div>
</div>


