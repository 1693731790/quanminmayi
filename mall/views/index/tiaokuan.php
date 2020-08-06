<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title =$model->title;
?>
<?php if(!isset($_GET["tiaokuan"])):?>

  <div class="Head88 pt88">
   <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff"><?=$model->title?></h2>
  </header>
  <?php endif;?>
  <div class="IntroducesBox" >
    <h1 style="text-align: center;font-size: 20px;"><?=$model->title?></h1>
    <br>
    <?=$model->content?>
  </div>
</div>