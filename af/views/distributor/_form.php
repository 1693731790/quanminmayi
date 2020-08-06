<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Distributor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distributor-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'user_id')->textInput() ?>
    <div class="form-group">
        <div class="row">
            <div class="col-md-10">
                <span class="btn btn-warning" onclick="userSelect()">选择用户</span>
            </div>
        </div>
    </div>
  

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
  	
    function userSelect()
    {

        layer.open({
          type: 2,
          title: '选择用户',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['distributor/user-select'])?>" //iframe的url
        }); 
    }

</script>
