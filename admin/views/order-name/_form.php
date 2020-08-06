<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderName */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<div class="order-name-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, 'goods_name')->textInput(['maxlength' => true]) ?>
  
  
<div class="form-group field-ordername-goods_name ">
	<label class="control-label" for="ordername-goods_name"></label>
	<span class="btn btn-success" onclick="goodsselect()">选择商品名称</span>

	<div class="help-block"></div>
</div>
  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
  function goodsselect()
  {

    layer.open({
      type: 2,
      title: '选择商品名称',
      shadeClose: true,
      shade: 0.8,
      area: ['700px', '90%'],
      content: "<?=Url::to(['goods/goods-select',"orderName"=>"1"])?>" //iframe的url
    }); 
  }
</script>
