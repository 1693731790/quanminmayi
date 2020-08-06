<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="消息提示";
?>

<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd"> <span ></span>
    <h2 style="width: 16.15rem;">消息提示</h2>
  </header>
</div>
<div class="Web_Box nb">
  <div class="NewsList">
    <ul>
  
      <li>
          
          <div class="con">
            <p class="f26">
              <span class="fr w385 cr_898989" style="width:100%;color:#a7473a" ><?=$message?></span>
            </p>
            <p class="f26">
              <span class="fr w385 cr_898989" style="width:100%"><a href="<?=Url::to(["index/index"])?>" style="color:#377af8">返回首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="javascript:history.go(-1)" style="color:#377af8">返回上一页</a></span>
            </p>
          </div>
          
      </li>
  
    </ul>
  </div>
</div>