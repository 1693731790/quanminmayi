<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserFeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户反馈';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-feedback-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'feedback_id',
            'user_id',
            'phone',
            'content:ntext',
            'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',//
                'buttons'=>[
                    
                    
                    'delete'=>function($url,$model){
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
                    },
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>
