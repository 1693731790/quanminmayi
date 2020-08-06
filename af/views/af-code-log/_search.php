<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AfCodeLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="af-code-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'user_phone') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
