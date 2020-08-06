<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="我的收货地址";
?>

<div class="Head88 " style="padding-bottom:68px;">

  <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">收货地址</h2>
  </header>
</div>
<div class="Web_Box">
  
  <div class="AddressList bg_fff">
      <ul>
        <?php foreach($model as $value):?>
        <li>
          <div class="con1">
            <h2><?=$value->name?> </h2>
            <div class="phone"><?=$value->phone?></div>
          </div>
          <div class="con2"> <span><?=$value->isdefault==1?'[默认地址]':''?></span><?=$value->region?> &nbsp;&nbsp;<?=$value->address?></div>
          <i class="select iconfont icon-del4" style="color:#fd6847" onclick="adelete(<?=$value->aid?>,this)"></i> 
          
        </li>
        <?php endforeach;?>
      </ul>
    </div>
</div>

<div class="BottomGd">
  <a href="<?=Url::to(['user/address-createf'])?>"><button class="but_2 wauto" style="background:#fc3b3e" type="button">+添加新地址</button></a>
</div>

<script type="text/javascript">
function adelete(id,obj){
  $.get("<?=Url::to(['user/address-delete'])?>",{"aid":id},function(r){
      layer.msg(r.message);
      if(r.success)
      {
          $(obj).parent().remove();
      }
  },'json')
}
</script>