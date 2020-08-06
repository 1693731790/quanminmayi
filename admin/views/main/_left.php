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
            
           
          <?php foreach($menuListOne as $oneVal):?>  <!--一级菜单-->
          
            <?php 
              $menuListTwo=$menu->getMenu($oneVal->id);  
            ?>
            <?php foreach($menuListTwo as $towVal):?>  <!--二级菜单-->
                <?php 
                    $menuListThree=$menu->getMenu($towVal->id);
                ?>
                <li class="treeview rfLeftMenu rfLeftMenu-<?=$oneVal->id?>">
                    <?php if(empty($menuListThree)):?>  <!--判断三级菜单是否存在-->
                      <a class="J_menuItem"  href="<?=$towVal->route?>" >
                        <i class="fa fa-suitcase rf-i"></i> <span><?=$towVal->name?></span>
                      </a>
                    <?php else:?>
                      <a href="#">
                        <i class="fa fa-suitcase rf-i"></i> <span><?=$towVal->name?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                    <?php endif;?>

                   
                    <ul class="treeview-menu">
                      <?php foreach($menuListThree as $threeVal):?><!--三级菜单-->
                        <li class="treeview rfLeftMenu rfLeftMenu-<?=$oneVal->id?>">
                            <a class="J_menuItem" href="<?=$threeVal->route?>" >
                                <i class="fa "></i>
                                <span><?=$threeVal->name?></span>
                            </a>
                        </li>
                       
                      <?php endforeach;?>
                    </ul>
                </li>

            <?php endforeach;?>
          <?php endforeach;?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>