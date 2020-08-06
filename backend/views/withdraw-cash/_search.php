<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WithdrawCashSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-cash-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'wid') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'fee') ?>

    <?= $form->field($model, 'real_fee') ?>

    <?php // echo $form->field($model, 'bank_id') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'handle_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
