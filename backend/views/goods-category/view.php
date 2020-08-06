<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cate_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cate_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cate_id',
            'pid',
            'name',
            'level',
            'sort',
            'cate_img',
            'adv_img',
            'adv_url:url',
        ],
    ]) ?>

</div>
