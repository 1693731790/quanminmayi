<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="关于我们";
?>

<div class="Head88 pt88">
   <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">关于我们</h2>
  </header>
  
  <div class="IntroducesBox" >
    <?=$model->content?>
  </div>
</div>