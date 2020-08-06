<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AgentBalanceRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '预存余额记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-balance-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

			
            'id',
			 ['attribute'=>'type',
               'value'  => function($model){
                     return $model->type=="1"?"收入":"支出";
               },
               'filter'=>["1"=>"收入","2"=>"支出"],
            ],
            
            'fee',
			'remarks',
             'create_time:datetime',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
