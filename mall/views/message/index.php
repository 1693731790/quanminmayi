<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="消息列表";
?>

<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">消息列表</h2>
  </header>
</div>
<div class="Web_Box nb">
  <div class="NewsList">
    <ul>
  <?php foreach($model as $val):?>
      <li>
          <div class="time tc"> <span><?=date("Y-m-d H:i:s",$val->create_time)?></span> </div>
          <div class="con">
            <p class="f26"><span class="fr w385 cr_898989" style="width:100%"><?=$val->content?></span></p>
            
          </div>
          
      </li>
  <?php endforeach;?>
    </ul>
  </div>
</div>