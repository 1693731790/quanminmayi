<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use front\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

AppAsset::register($this);

 $cookie = \Yii::$app->request->cookies;
$shop_id=$cookie->getValue("shop_id");

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta content="telephone=no" name="format-detection" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no, email=no" />
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<meta name="full-screen" content="yes">
<meta name="x5-fullscreen" content="true">
<meta name="browsermode" content="application">
<meta name="x5-page-mode" content="app">

<meta content="email=no" name="format-detection" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>
<body onload="loaded()">
<?php $this->beginBody() ?>

    <?=$content?>

  	
<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')||strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false):?>
  
  <?php if(!empty($shop_id)):?>
  <link rel="stylesheet" type="text/css" href="/shopstatic/font/storeiconfont.css">
  <style>
    .nav li {width:25%;}
footer{ margin: 0 auto; position: fixed;bottom:0; left:0; right: 0 ;z-index: 2}
.store-footer{height:2.05rem; border-top:1px solid #d7d6db; background-color: #fff}
.store-footer ul li a{width:25%; float: left; height: 100%; text-align: center; color: #7f8699; font-size: .5rem; line-height: .7rem}
.store-footer ul li a i{font-size: 0.84rem ; display:block; width:100%;padding-top:0.40rem;padding-bottom: .12rem}
.store-footer ul li a.active i{ color:#dd00d5; }
.store-footer ul li a.active p,.store-footer ul li a.active:hover  p{color:#dd00d5;}
</style>
  
  <footer>
	<div class="store-footer">
		<ul>
			<li>
				<a href="<?=Url::to(["shops/shop-info","shop_id"=>$shop_id])?>">
					<i class="storeiconfont store-index"></i>
					<p>首页</p>
				</a>
			</li>
			<li>
                <a href="<?=Url::to(["shops/shop-cate","shop_id"=>$shop_id])?>">
					<i class="storeiconfont store-fenlei"></i>
					<p>产品分类</p>
				</a>
			</li>
			<li>
				<a href="<?=Url::to(["shopcar/shopcar-list"])?>">
					<i class="storeiconfont store-car"></i>
					<p>购物车</p>
				</a>
			</li>
			<li>
				<a href="<?=Url::to(["user/index"])?>">
					<i class="storeiconfont store-my"></i>
					<p>我的</p>
				</a>
			</li>
		</ul>
	</div>
</footer>	
  
  
  
	<?php else:?>  
  

  

  

  <style>
    .nav li {-width:25%;}
  </style>
<nav class="nav">
  <ul>
    <li <?=$this->context->id=="index"?'class="on"':''?> > 
      <a href="<?=$this->context->id=="index"&&$this->context->action->id=="index"?'javascript:;':Url::to(["index/index"])?>"> <i class="iconfont icon-home2"></i>
      <p>首页</p>
      </a> </li>
    <li <?=$this->context->id=="my-shop"?'class="on"':''?>> 
      <a href="<?=$this->context->id=="my-shop"&&$this->context->action->id=="index"?'javascript:;':Url::to(["my-shop/open-shop"])?>"><i class="iconfont icon-shop"></i> <i class="iconfont icon-shopon"></i>
      <p>开店</p>
      </a> </li>
     <li <?=$this->context->id=="phone"?'class="on"':''?>> 
      <a href="<?=$this->context->id=="phone"&&$this->context->action->id=="index"?'javascript:;':Url::to(["phone/index"])?>"><i class="iconfont icon-telephone" style="transform:rotate(90deg)"></i> 
      <p>通话</p>
      </a> </li>
    <li <?=$this->context->id=="goods-cate"?'class="on"':''?>>
       <a href="<?=$this->context->id=="goods-cate"&&$this->context->action->id=="index"?'javascript:;':Url::to(["goods-cate/index"])?>"> <i class="iconfont icon-classification"></i> <i class="iconfont icon-classificationon"></i>
      <p>分类</p>
      </a> </li>
    <li <?=$this->context->id=="user"?'class="on"':''?>> 
       <a href="<?=$this->context->id=="user"&&$this->context->action->id=="index"?'javascript:;':Url::to(["user/index"])?>"> <i class="iconfont icon-my"></i> <i class="iconfont icon-myon"></i>
      <p>我的</p>
      </a> </li>
  </ul>
</nav>
  <?php endif;?>
      
<?php endif;?>   
  
<!--

<li <?=$this->context->id=="phone"?'class="on"':''?>> 
      <a href="<?=$this->context->id=="phone"&&$this->context->action->id=="index"?'javascript:;':Url::to(["phone/index"])?>"><i class="iconfont icon-telephone" style="transform: rotate(90deg);-ms-transform: rotate(90deg);-moz-transform: rotate(90deg);-webkit-transform: rotate(90deg);-o-transform: rotate(90deg);display: inline-block!important;"></i>
      <p>通话</p>
      </a> </li>

<style>
  .pill ul li{margin-left: 1.2rem;}
  </style>
  
<div class="pill">
    <ul>
    <li>
    <a href="<?=$this->context->id=="index"&&$this->context->action->id=="index"?'javascript:;':Url::to(["index/index"])?>">
    <div class="piml"><img class="" src="/webstatic//images/app01_14.jpg"></div>
    <div class="piol">首页</div>
    </a>
    </li>
    <li><a href="<?=$this->context->id=="goods-cate"&&$this->context->action->id=="index"?'javascript:;':Url::to(["goods-cate/index"])?>"> <div class="piml"><img class="" src="/webstatic/images/appfive_05.jpg"></div>
    <div class="piol">分类</div></a></li>
    <!--<li> <a href="indexs.html"><div class="piml"><img class="" src="/webstatic/images/appfive_07.jpg"></div>
    <div class="piol">通话</div></a></li>
    <li> <a href="<?=$this->context->id=="my-shop"&&$this->context->action->id=="index"?'javascript:;':Url::to(["my-shop/index"])?>"><div class="piml"><img class="" src="/webstatic/images/appfive_09.jpg"></div>
    <div class="piol">开店</div></a></li>
    <li><a href="<?=$this->context->id=="user"&&$this->context->action->id=="index"?'javascript:;':Url::to(["user/index"])?>"> <div class="piml"><img class="" src="/webstatic/images/appfive_11.jpg"></div>
    <div class="piol">我的</div></a></li>
    </ul>
 </div>   -->
 
  <script src="/webstatic/js/TouchSlide.1.1.js"></script>
    <script src="/webstatic/js/jquery.vticker.min.js"></script>

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
  
<?php $this->endBody() ?>

<script type="text/javascript">
   
</script>

</body>
</html>
<?php $this->endPage() ?>