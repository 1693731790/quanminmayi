<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MobileCardOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电话卡订单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mobile-card-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'mo_id',
          	
            'morder_sn',
            'partner_id',
            'agent_id',
            'total_fee',
            // 'mi_id',
            // 'phone',
            // 'pay_img',
             ['attribute'=>'status',
                'value'=>function($model){
                   
                        return Yii::$app->params['mobile_card_order_status'][$model->status];
                 },
              'filter'=>Yii::$app->params['mobile_card_order_status'],
            ],
             'create_time:datetime',

             ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',//
                'buttons'=>[
                    
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>
