<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shop_id')->textInput() ?>

    <?= $form->field($model, 'cate_id1')->textInput() ?>

    <?= $form->field($model, 'cate_id2')->textInput() ?>

    <?= $form->field($model, 'cate_id3')->textInput() ?>

    <?= $form->field($model, 'goods_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_keys')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_thums')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_img')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'old_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salecount')->textInput() ?>

    <?= $form->field($model, 'issale')->textInput() ?>

    <?= $form->field($model, 'ishot')->textInput() ?>

    <?= $form->field($model, 'isnew')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
