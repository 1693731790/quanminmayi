<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RobBuySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '秒杀商品';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rob-buy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
            'rob_id',
            //'shop_id',
            'goods_id',
            'num',
            'price',
            'start_time:datetime',
            'end_time:datetime',

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
