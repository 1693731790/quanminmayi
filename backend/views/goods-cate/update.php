<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = '编辑: ' . $model->goods_cat_name;
$this->params['breadcrumbs'][] = ['label' => '商品分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑：'. $model->goods_cat_name;
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
