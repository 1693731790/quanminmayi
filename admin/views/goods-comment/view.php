<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsComment */

$this->title = $model->cid;
$this->params['breadcrumbs'][] = ['label' => 'Goods Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cid], [
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
            'cid',
            'goods_id',
            'order_id',
            'user_id',
            'type',
            'goods_score',
            'service_score',
            'time_score:datetime',
            'content:ntext',
            'images',
            'ishide',
            'create_time:datetime',
        ],
    ]) ?>

</div>
