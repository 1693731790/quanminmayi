<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WalletSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'wid') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'fee') ?>

    <?= $form->field($model, 'before_fee') ?>

    <?php // echo $form->field($model, 'after_fee') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'order_sn') ?>

    <?php // echo $form->field($model, 'd_id') ?>

    <?php // echo $form->field($model, 'd_sn') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
