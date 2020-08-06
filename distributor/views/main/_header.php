<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<header class="main-header">
    <!-- Logo区域 -->
    <a href="<?= Yii::$app->homeUrl; ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">全民蚂蚁经销商</span>
    </a>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div class="navbar-custom-menu pull-left">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu rfTopMenu">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">切换导航</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
               		
                    <!--     <li class="dropdown notifications-menu rfTopMenu hide" data-type="<?=$val->id?>" data-is_addon="0">
                            <a class="dropdown-toggle">
                                <i class="fa fa-bookmark"></i> <?=$val->name?>
                            </a>
                        </li>-->
					<li class="dropdown notifications-menu rfTopMenu" data-type="13" data-is_addon="0">
                            <a class="dropdown-toggle">
                                <i class="fa fa-bookmark"></i> 网站功能                            </a>
                        </li>

            </ul>
        </div>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img class="user-image head_portrait" src="/resources/dist/img/profile_small.jpg"/>
                        <span class="hidden-xs"> <?=Yii::$app->user->identity->username?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img class="img-circle head_portrait" src="/resources/dist/img/profile_small.jpg"/>
                            <p>
                                 <?=Yii::$app->user->identity->username?>
                                
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="<?= Url::to(['/rbac/admin/index']); ?>" class="J_menuItem" onclick="$('body').click();">设置</a>
                                </div>
                                
                                <div class="col-xs-4 text-center">
                                   <a href="javascript:clear();">清除缓存</a>
                                    
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                <li id="logout" class="hide">
                    <a href="<?= Url::to(['site/logout']); ?>" data-method="post"><i class="fa fa fa-sign-out"></i>退出</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script type="text/javascript">
    function clear(){
        $.get("<?=Url::to(['site/clear'])?>",{},function(res){
            layer.msg(res.message);
        },'json');

    }
</script>