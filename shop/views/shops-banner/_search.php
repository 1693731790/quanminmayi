<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ShopsBannerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shops-banner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'banner_id') ?>

    <?= $form->field($model, 'shop_id') ?>

    <?= $form->field($model, 'img') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'orderby') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
