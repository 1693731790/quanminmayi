<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AgentFeeRecord */

$this->title = $model->record_id;
$this->params['breadcrumbs'][] = ['label' => 'Agent Fee Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-fee-record-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->record_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->record_id], [
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
            'record_id',
            'user_id',
            'agent_id',
            'fee',
            'create_time:datetime',
        ],
    ]) ?>

</div>
