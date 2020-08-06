<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SpecialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = '专题列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加专题', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'special_id',
            'goods_id',
            'name',
            ['attribute' => 'img',
                 'format' => ['image',['width'=>'150','height'=>'110','title'=>'图片']],
                 'value'  => function($model){
                    return $model->img;
                 }
            ],
            ['attribute'=>'ishome',
                "value"=>function($model){
                    return $model->ishome=="1"?"是":"否";
                }
            ],
            'browse',
            'orderby',
            //'content:ntext',
            // 'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{delete}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
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
