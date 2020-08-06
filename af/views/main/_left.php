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
          	
  
          
          
          	<li class="treeview ">
                      <!--判断三级菜单是否存在-->
                      <a class="J_menuItem" href="/site/index" data-index="1">
                        <i class="fa fa-suitcase rf-i"></i> <span>后台首页</span>
                      </a>
                    <ul class="treeview-menu"></ul>
             </li>
			 <li class="treeview ">
                     <a href="#">
                        <i class="fa fa-suitcase rf-i"></i> <span>防伪码管理</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                    <ul class="treeview-menu" style="display: none;">
                      <!--三级菜单-->
                        <li class="treeview  ">
                            <a class="J_menuItem" href="<?=Url::to(["af-code/index"])?>" data-index="1">
                                <i class="fa "></i>
                                <span>防伪码列表</span>
                            </a>
                        </li>
                       <li class="treeview  ">
                            <a class="J_menuItem" href="<?=Url::to(["af-code-log/index"])?>" data-index="1">
                                <i class="fa "></i>
                                <span>使用详情</span>
                            </a>
                        </li>
                        <li class="treeview  ">
                            <a class="J_menuItem" href="<?=Url::to(["af-code/create"])?>" data-index="2">
                                <i class="fa "></i>
                                <span>添加防伪码</span>
                            </a>
                        </li>
                       
                     </ul>
            </li>          
            <li class="treeview ">
                     <a href="#">
                        <i class="fa fa-suitcase rf-i"></i> <span>经销商</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                    <ul class="treeview-menu" style="display: none;">
                      <!--三级菜单-->
                        <li class="treeview  ">
                            <a class="J_menuItem" href="<?=Url::to(["distributor/index"])?>" data-index="1">
                                <i class="fa "></i>
                                <span>经销商列表</span>
                            </a>
                        </li>
                      <li class="treeview  ">
                            <a class="J_menuItem" href="<?=Url::to(["distributor/create"])?>" data-index="1">
                                <i class="fa "></i>
                                <span>添加经销商</span>
                            </a>
                        </li>
                       
                       
                     </ul>
            </li>          
            <li class="treeview ">
                     <a href="#">
                        <i class="fa fa-suitcase rf-i"></i> <span>商品管理</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                    <ul class="treeview-menu" style="display: none;">
                      <!--三级菜单-->
                        <li class="treeview  ">
                            <a class="J_menuItem" href="<?=Url::to(["goods/index"])?>" data-index="1">
                                <i class="fa "></i>
                                <span>商品列表</span>
                            </a>
                        </li>
                        <li class="treeview  ">
                            <a class="J_menuItem" href="<?=Url::to(["goods/create"])?>" data-index="2">
                                <i class="fa "></i>
                                <span>添加商品</span>
                            </a>
                        </li>
                       
                     </ul>
            </li>
           <li class="treeview ">
                     <a href="#">
                        <i class="fa fa-suitcase rf-i"></i> <span>订单管理</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                    <ul class="treeview-menu" style="display: none;">
                      <!--三级菜单-->
                        <li class="treeview  ">
                            <a class="J_menuItem" href="<?=Url::to(["af-order/index"])?>" data-index="1">
                                <i class="fa "></i>
                                <span>订单列表</span>
                            </a>
                        </li>
                       
                     </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>