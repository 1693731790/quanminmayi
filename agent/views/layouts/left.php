<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Nav;

use yii\bootstrap\NavBar;
use dmstr\widgets\Menu;
use common\models\Agent;
$agentType=Agent::getAgentType();
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
            <span>首页</span>
        </a>
    </li>

    <?php if($agentType=="2"): ?>
    <li class="has-sub">
        <a href="/agent/mobile-card-create">
            <i class="fa fa-circle-o"></i>  
            <span>购买话费充值卡</span>
        </a>
    </li>
    <?php endif;?>
  
    <?php if($agentType=="1"): ?>
    <li class="has-sub">
        <a href="/agent/index">
            <i class="fa fa-circle-o"></i>  
            <span>我的代理商列表</span></a>
    </li>
    <li class="has-sub">
        <a href="/agent/create">
            <i class="fa fa-circle-o"></i>  
            <span>添加代理商</span></a>
    </li>
    <li class="has-sub">
        <a href="/agent-balance-record/index">
            <i class="fa fa-circle-o"></i>  
            <span>预存余额明细</span></a>
    </li>
    <?php endif;?>

    
    
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