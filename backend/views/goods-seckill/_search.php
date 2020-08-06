<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsSeckillSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-seckill-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'goods_id') ?>

    <?= $form->field($model, 'goods_sn') ?>

    <?= $form->field($model, 'goods_name') ?>

    <?= $form->field($model, 'goods_keys') ?>

    <?= $form->field($model, 'goods_thums') ?>

    <?php // echo $form->field($model, 'goods_img') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'old_price') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'hour') ?>

    <?php // echo $form->field($model, 'status_info') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'mobile_content') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
