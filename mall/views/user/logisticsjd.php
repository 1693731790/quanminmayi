<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="物流信息";
?>

<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd"> <span onclick="javascript:history.go(-1)"><i class="iconfont icon-leftdot"></i></span>
    <h2>物流信息</h2>
  </header>
</div>
<div class="Web_Box">
  
  <div class="AddressList bg_fff">
      <ul>
     
        <?php if(!empty($res)&&$res->RESPONSE_STATUS=="true"&&isset($res->RESULT_DATA->contents)):?>
        
        <?php foreach(array_reverse($res->RESULT_DATA->contents) as $val):?>
        <li>
          <div class="con1">
            <div class="phone" style="width:100%"><?=$val->time?></div>
          </div>
          <div class="con2"> <span><?=$val->description?></span></div>
          
        </li>
        <?php endforeach;?>
        <?php else:?>
            <li>
              <div class="con1">
                <div class="phone" style="width:100%">暂无物流记录</div>
              </div>
              
              
            </li>
        <?php endif;?>
     
      </ul>
    </div>
</div>
