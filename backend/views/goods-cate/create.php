<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = '添加类目';
$this->params['breadcrumbs'][] = ['label' => '商品分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
