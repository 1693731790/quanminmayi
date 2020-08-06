<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="订单编码";
?>

<div class="Head88 pt88">
   <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">订单编码</h2>
  </header>
  
  <div class="IntroducesBox" >
    <br/>
    订单号：<span style="color:red"><?=$order->order_sn?></span>
    <?php if($orderGoods[0]->goods->is_group==1&&$order->status=="1"):?>
    <img src="/barcode/example/code/test_code39.php?text=<?=$order->order_sn?>" style="width:98%;height:50px; margin-top:30px;" />
    <?php endif;?>
  </div>
</div>