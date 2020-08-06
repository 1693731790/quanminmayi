<?php
use yii\helpers\Html;
use yii\helpers\Url;
use admin\models\Menu;
$menu=new Menu();
$menuListOne=$menu->getMenu();

?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img class="img-circle head_portrait" src="/resources/dist/img/profile_small.jpg"/>
            </div>
            <div class="pull-left info">
                <p> <?=Yii::$app->user->identity->username?></p>
                <a href="#">
                    <i class="fa fa-circle text-success"></i>
                    
                        超级管理员
                    
                </a>
            </div>
        </div>
        <!-- 侧边菜单 -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header" data-rel="external">系统菜单</li>
          	
  
          
          
          	<!--<li class="treeview ">
                
                      <a class="J_menuItem" href="/site/index" data-index="1">
                        <i class="fa fa-suitcase rf-i"></i> <span>后台首页</span>
                      </a>
                    <ul class="treeview-menu"></ul>
             </li>-->
             <li class="treeview ">
                      <!--判断三级菜单是否存在-->
                      <a class="J_menuItem" href="<?=Url::to(["goods/index"])?>" data-index="1">
                        <i class="fa fa-suitcase rf-i"></i> <span>商品列表</span>
                      </a>
                    <ul class="treeview-menu"></ul>
             </li>
             <li class="treeview ">
                      <!--判断三级菜单是否存在-->
                      <a class="J_menuItem" href="<?=Url::to(["order/index"])?>" data-index="1">
                        <i class="fa fa-suitcase rf-i"></i> <span>我的订单</span>
                      </a>
                    <ul class="treeview-menu"></ul>
             </li>
		     

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>