<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsBrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '品牌';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-brand-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            ['attribute' => 'img',
                 'label' => '图',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'图片']],
                 'value'  => function($model){
                    return $model->img;
                 }
            ],

           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}',//
                'buttons'=>[
                   
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
