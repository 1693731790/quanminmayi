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

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group field-ordersearch-start_time">
<label class="control-label" for="ordersearch-start_time">开始时间</label>
<input type="text" id="ordersearch-start_time" class="form-control" name="start_time"  value="<?=$_GET['start_time']?>" lay-key="1">

<div class="help-block"></div>
</div>
  
  <div class="form-group field-ordersearch-end_time">
<label class="control-label" for="ordersearch-end_time">结束时间</label>
<input type="text" id="ordersearch-end_time" class="form-control" name="end_time"  value="<?=$_GET['end_time']?>" lay-key="2">

<div class="help-block"></div>
</div>
  

  
<div class="form-group field-ordersearch-start_time">
<label class="control-label" for="ordersearch-start_time">推荐人手机号</label>
<input type="text" id="parent_phone" class="form-control"  name="parent_phone"  value="<?=$_GET['parent_phone']?>" lay-key="1">

<div class="help-block"></div>
</div>


<div class="help-block"></div>
</div>
  

  
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        
    </div>


    <?php ActiveForm::end(); ?>
    <div class="form-group">
      <span class="btn btn-success" id="timeall">按条件导出</span>
      <span class="btn btn-success" id="all">导出全部</span>
    </div>
</div>

<script>
  $(function(){
  	$("#all").click(function(){
    	window.location.href="<?=Url::to(["excel/all"])?>";
    })
    $("#timeall").click(function(){
    	var start_time=$("#ordersearch-start_time").val();
      var end_time=$("#ordersearch-end_time").val();
        var parent_phone=$("#parent_phone").val();
    	window.location.href="<?=Url::to(["excel/all"])?>"+"?parent_phone="+parent_phone+"&start_time="+start_time+"&end_time="+end_time;
      
    })
  })
  //执行一个laydate实例
laydate.render({
  elem: '#ordersearch-start_time' //指定元素
});
      //执行一个laydate实例
laydate.render({
  elem: '#ordersearch-end_time' //指定元素
});
  
</script>
