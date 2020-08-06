<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ads_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'sort') ?>

    <?= $form->field($model, 'images') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
