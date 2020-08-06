<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AfOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="af-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'd_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'order_sn') ?>

    <?= $form->field($model, 'total_fee') ?>

    <?php // echo $form->field($model, 'address_name') ?>

    <?php // echo $form->field($model, 'address_phone') ?>

    <?php // echo $form->field($model, 'address_region') ?>

    <?php // echo $form->field($model, 'address_region_id') ?>

    <?php // echo $form->field($model, 'address_address') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'pay_img') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'express_type') ?>

    <?php // echo $form->field($model, 'express_num') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
