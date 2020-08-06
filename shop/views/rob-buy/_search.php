<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RobBuySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rob-buy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rob_id') ?>

    <?= $form->field($model, 'shop_id') ?>

    <?= $form->field($model, 'goods_id') ?>

    <?= $form->field($model, 'num') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
