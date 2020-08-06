<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\RechargeCard */

$this->title = '新增充值卡';
$this->params['breadcrumbs'][] = ['label' => '充值卡管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recharge-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="form-group field-config-web_link">
	<label class="control-label" for="config-web_link">批号</label>
	<input type="text" id="batch_num"  class="form-control" style="width:200px" name="batch_num" value="">
</div>  
  
<div class="form-group field-config-web_link">
	<label class="control-label" for="config-web_link">增加数量</label>
	<input type="text" id="num"  class="form-control" style="width:200px" name="num" value="">
</div>
  
<div class="form-group field-config-web_link">
	<label class="control-label" for="config-web_link">增加金额</label>
	<input type="text" id="fee" class="form-control" style="width:200px" name="fee" value="" >
</div>

  
  <div class="form-group">
        <button type="button" onclick="sub()" class="btn btn-primary">确定</button> 
  </div>
  
</div>

<script>

function sub() {
  	var num=$("#num").val();
    var fee=$("#fee").val();
    var batch_num=$("#batch_num").val();
  
    var ok=true;
    if(num=="")
    {
     	layer.msg("请输入数量");
        ok=false;
        return false;
    }
    if(num=="")
    {
        layer.msg("请输入金额");
     	ok=false;
        return false;
    }
    if(ok)
    {
    	$.get("<?=Url::to(['recharge-card/create'])?>",{"num":num,"fee":fee,"batch_num":batch_num},function(r){
               layer.msg(r.message);
    	  	   if(r.success)
               {
                	setTimeout(function(){
                    	window.location.reload(); 
                    },1500); 
               } 
		},"json") 
    }
    
 
}
</script>