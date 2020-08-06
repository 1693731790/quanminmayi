<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RobBuy */

$this->title = $model->rob_id;
$this->params['breadcrumbs'][] = ['label' => 'Rob Buys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rob-buy-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rob_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rob_id], [
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
            'rob_id',
            'shop_id',
            'goods_id',
            'num',
            'price',
            'start_time:datetime',
            'end_time:datetime',
        ],
    ]) ?>

</div>
