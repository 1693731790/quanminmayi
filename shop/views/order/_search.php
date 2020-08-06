<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'order_sn') ?>

    <?= $form->field($model, 'shop_id') ?>

    <?= $form->field($model, 'goods_id') ?>

    <?php // echo $form->field($model, 'total_fee') ?>

    <?php // echo $form->field($model, 'deliver_fee') ?>

    <?php // echo $form->field($model, 'address_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'pay_status') ?>

    <?php // echo $form->field($model, 'pay_type') ?>

    <?php // echo $form->field($model, 'pay_time') ?>

    <?php // echo $form->field($model, 'pay_num') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'is_comment') ?>

    <?php // echo $form->field($model, 'is_refund') ?>

    <?php // echo $form->field($model, 'refund_remarks') ?>

    <?php // echo $form->field($model, 'is_settlement') ?>

    <?php // echo $form->field($model, 'use_score') ?>

    <?php // echo $form->field($model, 'get_score') ?>

    <?php // echo $form->field($model, 'delivery_time') ?>

    <?php // echo $form->field($model, 'receive_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
