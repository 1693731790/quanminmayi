<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Wallet */

$this->title = $model->wid;
$this->params['breadcrumbs'][] = ['label' => 'Wallets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->wid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->wid], [
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
            'wid',
            'user_id',
            'type',
            'fee',
            'before_fee',
            'after_fee',
            'order_id',
            'order_sn',
            'd_id',
            'd_sn',
            'create_time:datetime',
        ],
    ]) ?>

</div>
