<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserAddressSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-address-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'aid') ?>
    <?= $form->field($model, 'user_id') ?>
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'region') ?>

    <?= $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'isdefault') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
