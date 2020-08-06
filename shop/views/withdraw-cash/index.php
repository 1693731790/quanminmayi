<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WithdrawCashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-cash-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

           // 'wid',
           // 'type',
           // 'user_id',
            'fee',
           // 'real_fee',
            // 'bank_id',
             'phone',
             
             [
                'attribute'=>'status',
                
                'value'=>function($model){
                    return yii::$app->params['withdraw_cash_status'][$model->status];
                },
                'filter'=>yii::$app->params['withdraw_cash_status'],
               
            ],

            // 'remark',
             'create_time:datetime',
            // 'handle_time:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',//{delete}
                'buttons'=>[
                   
                    'view'=>function($url,$model){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-success marr5']);
                        
                        
                    },
                    
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>
