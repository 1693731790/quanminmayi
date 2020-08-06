<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AgentChannel */

$this->title = $model->channel_id;
$this->params['breadcrumbs'][] = ['label' => 'Agent Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-channel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->channel_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->channel_id], [
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
            'channel_id',
            'gt_fee',
            'reward',
            'proportion',
        ],
    ]) ?>

</div>
