<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title ="设置";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/shezhi.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css">

<header>
          <a href="javascript:;" onclick="javascript:history.go(-1)"><div class="_lefte"><i class="iconfont icon-back is" ></i></div></a>
          设置
</header>

<a href="<?=Url::to(["site/logout"])?>"><div class="btn" style="position: absolute; top:5rem">退出登录</div></a>