<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CallLogCases */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '通话记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
    		//['class' => 'yii\grid\SerialColumn'],

         	 [
                "attribute"=>'id',
                  'options'=>[
                    'width'=>'80',
                ],
            ],
          [
                "attribute"=>'user_id',
                  'options'=>[
                    'width'=>'80',
                ],
            ],
            
            
            [
                "attribute"=>'caller',
                  'options'=>[
                    'width'=>'150',
                ],
            ],
            [
                "attribute"=>'called',
                  'options'=>[
                    'width'=>'150',
                ],
            ],
          	
            'start_time:datetime',
            'end_time:datetime',
            
          [
                "attribute"=>'call_time',
                  'options'=>[
                    'width'=>'100',
                ],
            ],
          [
                "attribute"=>'guishudi',
                  'options'=>[
                    'width'=>'120',
                ],
            ],
            
          	//'mobile_ip',
          	//'openid',
          	//'lon',
          	//'lat',
          	
          [
                "attribute"=>'fee',
                  'options'=>[
                    'width'=>'120',
                ],
            ],
          [
                "attribute"=>'balance',
                  'options'=>[
                    'width'=>'120',
                ],
            ],
           

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{delete}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
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
