<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Wallet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'before_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'after_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'order_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_id')->textInput() ?>

    <?= $form->field($model, 'd_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
