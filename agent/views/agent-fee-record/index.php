<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AgentFeeRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的销售额';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-fee-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'record_id',
           // 'user_id',
            //'agent_id',
            'fee',
            'create_time:datetime',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
