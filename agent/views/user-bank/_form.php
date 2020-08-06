<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserBank */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-bank-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
