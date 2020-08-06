<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Nav;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\NavBar;
use dmstr\widgets\Menu;
// 

?>
<style>
    body{font-size: 14px;font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;}
</style>
<!-- begin #header -->
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <!-- begin container-fluid -->
    <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <a href="<?=Yii::$app->homeUrl?>" class="navbar-brand" style="margin-top: -5px;"><img src="/images/logo.png" height="40px;" alt=""></a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end mobile sidebar expand / collapse button -->
        
        <!-- begin header navigation right -->
        <ul class="nav navbar-nav navbar-right">
            <?php foreach($top_navs as $v):?>
            <li class="<?=@$v['is_active']?'active':null?>"><a href="<?=$v['url'][0]==null?$v['items'][0]['url'][0]:$v['url'][0]?>"><?=$v['label']?></a></li>
            <?php endforeach?>
            <li>
                <a href="javascript:clear();">清除缓存</a>
            </li>
            <li class="dropdown navbar-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- <img src="/admin/img/user-13.jpg" alt="" />  -->
                    <span class="hidden-xs"></span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="javascript:;">个人资料</a></li>
                    <li><a href="javascript:;">设置</a></li>
                    <li class="divider"></li>
                    <li><?=Html::a('退出登录',['/site/logout'],['data-method'=>'post'])?></li>
                </ul>
            </li>

        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end #header -->

<script type="text/javascript">
    function clear(){
        $.post("<?=Url::to(['/site/clear'])?>",{},function(res){
            layer.msg(res.message);
        },'json');

    }
</script>
