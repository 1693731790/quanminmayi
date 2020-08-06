<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AfCodeLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '防伪码使用记录';

?>
<div class="af-code-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'code_id',
            //'user_id',
          
            ["attribute"=>"type",
             'format' => 'raw',
              "value"=>function($model){
                	if($model->type=="2")
                    {
                     	return "APP"; 
                    }else if($model->type=="1"){
                        return "微信";
                    }
                  
                }, 
               'filter'=>["2"=>"APP","1"=>"微信"],
               'options'=>[
                    'width'=>'200',
                ],
             ],
            'nickname',
            // 'user_phone',
             'address',
             'create_time:datetime',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
