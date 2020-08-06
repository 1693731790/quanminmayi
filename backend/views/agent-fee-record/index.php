<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AgentFeeRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agent Fee Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-fee-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Agent Fee Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'record_id',
            'user_id',
            'agent_id',
            'fee',
            'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
