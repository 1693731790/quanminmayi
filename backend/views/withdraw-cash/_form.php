<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WithdrawCash */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-cash-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'real_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_id')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'handle_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
