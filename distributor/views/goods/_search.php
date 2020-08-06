<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'goods_id') ?>

    <?= $form->field($model, 'shop_id') ?>

    <?php // $form->field($model, 'cate_id1') ?>

    <?php // $form->field($model, 'cate_id2') ?>

    <?php // $form->field($model, 'cate_id3') ?>

    <?php // echo $form->field($model, 'goods_sn') ?>

    <?php // echo $form->field($model, 'goods_name') ?>

    <?php // echo $form->field($model, 'goods_keys') ?>

    <?php // echo $form->field($model, 'goods_thums') ?>

    <?php // echo $form->field($model, 'goods_img') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'old_price') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'salecount') ?>

    <?php // echo $form->field($model, 'issale') ?>

    <?php // echo $form->field($model, 'ishot') ?>

    <?php // echo $form->field($model, 'isnew') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
