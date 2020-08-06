<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cate_id') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'level') ?>

    <?= $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'cate_img') ?>

    <?php // echo $form->field($model, 'adv_img') ?>

    <?php // echo $form->field($model, 'adv_url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
