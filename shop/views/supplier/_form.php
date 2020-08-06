<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Supplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'user_id')->textInput() ?>
	<input type="hidden"  name="Supplier[shop_id]" value="<?=$shop_id?>">
  	
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
