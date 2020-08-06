<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WalletSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '钱包记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'wid',
            'user_id',
            [
                'attribute'=>'type',
                
                'value'=>function($model){
                     return Yii::$app->params['wallet_type'][$model->type];
                },
                'filter'=>Yii::$app->params['wallet_type'],
                
            ],
            
            'fee',
            'before_fee',
             'after_fee',
            /* 'order_id',
             'order_sn',
             'd_id',
             'd_sn',*/
             'scale',
             'create_time:datetime',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
