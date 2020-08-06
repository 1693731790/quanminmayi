<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="信息提示";
?>

<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd"> 
    <h2 style="width:100%">信息提示</h2>
  </header>
</div>
<div class="FormFilling hidden mt20">
  <ul>
 
    <li class="mb20 mt20">
      <div class="rightcon w548" style="    line-height: 2.1rem;">
        您还没有购买大礼包，请购买大礼包升级会员
      </div>
    </li>
  </ul>
</div>
<div class="pl20 pr20 mt20">
  <button type="button" class="but_1 wauto" id="submit">去购买</button>
  
</div>

<script type="text/javascript">
  $(function(){
      $("#submit").click(function(){

        window.location.href = "<?=Url::to(["user-upgrade/goods"])?>";
    
        
      })
  })
</script>
