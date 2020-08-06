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
      <?php for($i=0;$i<count(array_reverse($datakd['Traces']));$i++):?>
           
        
        <li>
          <div class="con1">
            <div class="phone" style="width:100%"><?=$datakd['Traces'][$i]['AcceptTime']?></div>
          </div>
          <div class="con2"> <span><?=$datakd['Traces'][$i]['AcceptStation']?></span></div>
          
        </li>
      <?php endfor;?>
      </ul>
    </div>
</div>
