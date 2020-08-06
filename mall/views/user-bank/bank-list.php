<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="我的银行卡";
?>

<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd"> <span onclick="javascript:history.go(-1)"><i class="iconfont icon-leftdot"></i></span>
    <h2>我的银行卡</h2>
  </header>
</div>
<div class="Web_Box">
  
  <div class="AddressList bg_fff">
      <ul>
        <?php foreach($model as $value):?>
        <li>
          <div class="con1">
            <h2><?=$value->name?> </h2>
            <div class="phone"><?=$value->bank_name?></div>
          </div>
          <div class="con2"> <span><?=$value->account?></span> &nbsp;&nbsp;<?=$value->phone?></div>
          <i class="select iconfont icon-del4" style="color:#fd6847" onclick="adelete(<?=$value->bank_id?>,this)"></i> 
        </li>
        <?php endforeach;?>
      </ul>
    </div>
</div>

<div class="BottomGd">
  <a href="<?=Url::to(['user-bank/bank-create'])?>"><button class="but_2 wauto" type="button">+添加银行卡</button></a>
</div>

<script type="text/javascript">
function adelete(id,obj){
  $.get("<?=Url::to(['user-bank/bank-delete'])?>",{"bank_id":id},function(r){
      layer.msg(r.message);
      if(r.success)
      {
          $(obj).parent().remove();
      }
  },'json')
}
</script>