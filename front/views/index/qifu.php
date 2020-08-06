<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="企业服务";
?>

<link rel="stylesheet" type="text/css" href="/webstatic/css/lead.css">

<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>
<div class="leadbody">
<img class="leadbodyimg" src="/webstatic/images/qfindex.png"/>
</div>
<a href="https://cash.fxqifu.com/1000418?from=singlemessage&isappinstalled=0">
  <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')):?>
<!--<div class="leadtitle" style="top:6%">进入首页</div>-->
  <?php else:?>
  <div class="leadtitle" style="top:6%">进入首页</div>
  <?php endif;?>
</a>