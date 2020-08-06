<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AgentGoodscardLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品卡交易记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-goodscard-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'out_agent_id',
            'enter_agent_id',
            'num',
            'scFee',
            // 'create_time:datetime',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
