<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;


if(Yii::$app->controller->type==2){
    $this->title = '整车价格管理';
}
if(Yii::$app->controller->type==3){
    $this->title = '绿色通道价格管理';
}

$this->params['breadcrumbs'][] = $this->title;
?>
<style>input{width:100px;}</style>
<div class="car-length-index" id="app">

<p>
    <?= Html::a('添加车长', ['create'], ['class' => 'btn btn-success']) ?>
</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute'=>'length',
                'value'=>function($model){
                    return $model->length.'米';
                },
            ],
            //'sort',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}',
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    'delete'=>function($url){
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