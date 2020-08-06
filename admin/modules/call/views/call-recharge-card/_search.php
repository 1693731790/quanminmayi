<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<script src="/static/laydate/laydate.js"></script> <!-- 改成你的路径 -->
<div class="order-search">

<div class="form-group field-ordersearch-start_time">
  <label class="control-label" for="ordersearch-start_time">批号</label>
  <input type="text" id="batch_num" style="width:300px;" class="form-control" name="batch_num"  >
  <div class="help-block"></div>
</div>


    <div class="form-group">
      <span class="btn btn-success" id="timeall">按条件导出</span>
      <span class="btn btn-success" id="all">导出全部</span>
      <?= Html::a('分配经销商', ['set-call-agent'], ['class' => 'btn btn-danger']) ?>
    </div>
</div>

<script>
  $(function(){
  	$("#all").click(function(){
    	window.location.href="/excel-down/call-recharge-card";
    })
    $("#timeall").click(function(){
    	var batch_num=$("#batch_num").val();
        window.location.href="/excel-down/call-recharge-card?batch_num="+batch_num;
     
    })
  })
</script>
