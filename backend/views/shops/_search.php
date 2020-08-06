<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ShopsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shops-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'shop_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'shop_sn') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'truename') ?>

    <?php // echo $form->field($model, 'id_front') ?>

    <?php // echo $form->field($model, 'id_back') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'notice') ?>

    <?php // echo $form->field($model, 'browse') ?>

    <?php // echo $form->field($model, 'delivery_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
