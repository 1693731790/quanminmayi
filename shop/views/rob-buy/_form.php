<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RobBuy */
/* @var $form yii\widgets\ActiveForm */
?>

<link rel="stylesheet" type="text/css" href="/static/datetime/css/wui.min.css">
<link rel="stylesheet" type="text/css" href="/static/datetime/css/style.css">
<script type="text/javascript" src="/static/datetime/js/angular.min.js"></script>
<script type="text/javascript" src="/static/datetime/js/wui-date.js" charset="utf-8"></script>




<div class="rob-buy-form">

    <?php $form = ActiveForm::begin(['id'=>"formsub"]); ?>

 <div class="form-group field-shops-user_id required">
    <label class="control-label" for="shops-user_id">商品ID</label>
    <input type="text" style="width:300px;" id="special-goods_id" class="form-control" name="RobBuy[goods_id]" aria-required="true" value="<?=$model->goods_id?>" readonly="readonly">
    <span class="btn btn-success" onclick="goodsid()">选择商品</span>

    <div class="help-block"></div>
</div>

<div ng-app="app">
<div class="form-group field-robbuy-start_time required">
    <label class="control-label" for="robbuy-start_time">秒杀开始时间</label>
    <wui-date 
        format="yyyy-mm-dd hh:mm" 
        placeholder="请选择或输入日期" 
        id="start_time" 
        btns="{'ok':'确定','now':'此刻'}" 
        ng-model="start_time"
        name="start_timef"
        dateClass="start_time"
    >
    </wui-date>
    

    <div class="help-block"></div>
</div>

<div class="form-group field-robbuy-end_time required">
    <label class="control-label" for="robbuy-end_time">秒杀结束时间</label>
    <wui-date 
        format="yyyy-mm-dd hh:mm" 
        placeholder="请选择或输入日期" 
        id="end_time" 
        btns="{'ok':'确定','now':'此刻'}" 
        ng-model="end_time"
        name="end_timef"
        dateClass="end_time"
    >
    </wui-date>
   

    <div class="help-block"></div>
</div>
</div>
    

    <input type="hidden" name="start_time">
    <input type="hidden" name="end_time">

    <?= $form->field($model, 'num')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::button($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success sub' : 'btn btn-primary sub']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    var app = angular.module('app',["wui.date"]);
</script>
<script>

    function goodsid()
    {

        layer.open({
          type: 2,
          title: '选择商品id',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['goods/goods-select'])?>" //iframe的url
        }); 
    }
$(function(){
        $(".sub").click(function(){
            $("input[name=start_time]").val($("input[name=start_timef]").val());
            $("input[name=end_time]").val($("input[name=end_timef]").val());
            $("#formsub").submit();
        })
    })
</script>
