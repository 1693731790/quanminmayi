<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'article_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'title_img') ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'ishot') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
