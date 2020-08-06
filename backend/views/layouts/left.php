<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Nav;
use mdm\admin\components\MenuHelper;
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
                    <small>超级管理员</small>
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav --> 
        <?php
                echo common\widgets\Menu::widget( [ 
                'options' => ['class' => 'nav'], 
                'items' => $navs, 
                ] );
        ?>
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