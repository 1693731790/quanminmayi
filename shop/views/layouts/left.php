<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Nav;

use yii\bootstrap\NavBar;
use dmstr\widgets\Menu;

?>

<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src="/img/user.jpg" alt="" /></a>
                </div>
                <div class="info">
                    <?=Yii::$app->user->identity->username?>
                    
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav --> 
<ul class="nav">
    <li class="has-sub active">
        <a href="/site/index">
            <i class="fa fa-circle-o"></i>  
            <span>后台首页</span>
        </a>
    </li>
  <li class="has-sub">
        <a href="/shops-banner/index">
            <i class="fa fa-circle-o"></i>  
            <span>店铺banner图</span>
        </a>
    </li>

<li class="has-sub">
    <a href="javascript:;">
        <i class="fa fa-circle-o"></i>  
        <span>订单管理</span> 
        <span class="caret pull-right"></span>
    </a>
    <ul class='sub-menu' >
      <li class="has-sub">
            <a href="/order/index">
                <i class="fa fa-circle-o"></i>  
                <span>全部订单</span>
            </a>
        </li>  
      <li class="has-sub">
            <a href="/order/index?status=1">
                <i class="fa fa-circle-o"></i>  
                <span>待发货订单</span></a>
            </li>
        
      <li class="has-sub">
            <a href="/order/index?status=4">
                <i class="fa fa-circle-o"></i>  
                <span>申请退款订单</span></a>
            </li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <i class="fa fa-circle-o"></i>  
        <span>商品管理</span> 
        <span class="caret pull-right"></span>
    </a>
    <ul class='sub-menu' >
        <li class="has-sub">
            <a href="/goods/create">
                <i class="fa fa-circle-o"></i>  
                <span>添加商品</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="/goods/index?status=0">
                <i class="fa fa-circle-o"></i>  
                <span>待审核商品</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="/goods/index">
                <i class="fa fa-circle-o"></i>  
                <span>商品列表</span>
            </a>
        </li>
      <li class="has-sub">
            <a href="/shops-cate/index">
                <i class="fa fa-circle-o"></i>  
                <span>店铺品牌管理</span>
            </a>
        </li>
      <li class="has-sub">
            <a href="/shops-class/index">
                <i class="fa fa-circle-o"></i>  
                <span>店铺商品分类管理</span>
            </a>
        </li>
      <li class="has-sub">
            <a href="/supplier/index">
                <i class="fa fa-circle-o"></i>  
                <span>供货商管理</span>
            </a>
        </li>
        
        
    </ul>
</li>
<!--<li class="has-sub">
    <a href="javascript:;">
        <i class="fa fa-circle-o"></i>  
        <span>秒杀商品管理</span> 
        <span class="caret pull-right"></span>
    </a>
    <ul class='sub-menu' >
        <li class="has-sub">
            <a href="/rob-buy/create">
                <i class="fa fa-circle-o"></i>  
                <span>添加秒杀商品</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="/rob-buy/index?status=0">
                <i class="fa fa-circle-o"></i>  
                <span>秒杀商品列表</span>
            </a>
        </li>
    </ul>
</li>-->
<li class="has-sub">
    <a href="javascript:;">
        <i class="fa fa-circle-o"></i>  
        <span>财务管理</span> 
        <span class="caret pull-right"></span>
    </a>
    <ul class='sub-menu' >
        <li class="has-sub">
            <a href="/user-bank/index">
                <i class="fa fa-circle-o"></i>  
                <span>我的银行卡</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="/wallet/index">
                <i class="fa fa-circle-o"></i>  
                <span>钱包记录</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="/withdraw-cash/create">
                <i class="fa fa-circle-o"></i>  
                <span>申请提现</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="/withdraw-cash/index">
                <i class="fa fa-circle-o"></i>  
                <span>提现列表</span>
            </a>
        </li>
    </ul>
</li>
<li class="has-sub">
        <a href="/remind-send-goods/index">
            <i class="fa fa-circle-o"></i>  
            <span>提醒发货</span>
        </a>
    </li>
<!--<li class="has-sub">
        <a href="/shop-coupon/update">
            <i class="fa fa-circle-o"></i>  
            <span>优惠券管理</span>
        </a>
</li>-->
  
</ul>
      
      
      <ul class="nav">
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>

<!-- end #sidebar -->