<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserCallfeeLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户话费记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-callfee-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            
           ['attribute'=>'id',
                'options'=>[
                    'width'=>'100',
                ],
            ],
             ['attribute'=>'type',
                 'value'  => function($model){
                        return Yii::$app->params['user_callfee_log'][$model->type];
                   
                 },
                 'filter'=>Yii::$app->params['user_callfee_log'],
              'options'=>[
                    'width'=>'120',
                ],
            ],
            
           ['attribute'=>'user_id',
                'options'=>[
                    'width'=>'100',
                ],
            ],
            
            ['attribute'=>'fee',
                'options'=>[
                    'width'=>'170',
                ],
            ],
            ['attribute'=>'balance',
                'options'=>[
                    'width'=>'170',
                ],
            ],
            ['attribute'=>'card_num',
                'options'=>[
                    'width'=>'260',
                ],
            ],
          ['attribute'=>'phone',
                'options'=>[
                    'width'=>'160',
                ],
            ],
          ['attribute'=>'order_sn',
                'options'=>[
                    'width'=>'260',
                ],
            ],
           
             'create_time:datetime',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
