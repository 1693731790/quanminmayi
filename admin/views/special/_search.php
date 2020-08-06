<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SpecialSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="special-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'special_id') ?>

    <?= $form->field($model, 'goods_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'img') ?>

    <?= $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
