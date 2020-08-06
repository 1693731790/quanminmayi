<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\SpikeTime;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsSeckillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '秒杀商品';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-seckill-index">

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

            'goods_id',
          	['attribute' => 'goods_thums',
                 'label' => '商品主图',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'商品图片']],
                 'value'  => function($model){
                    return $model->goods_thums;
                 }
            ],
            
            'goods_name',
            //'goods_keys',
            
            
            // 'goods_img:ntext',
            // 'desc:ntext',
             'old_price',
             'price',
             'stock',
             'start_time:date',
             
          ['attribute' => 'hour',
             
             
                 'value'  => function($model){
                    return SpikeTime::getSpikeOne($model->hour);
                 }
            ],
         /* ['attribute'=>'status',
               'label' => '审核状态',
                 'format' => 'raw',
                 'value'  => function($model){
                    if($model->status=="0")
                    {
                        return "<a onclick='status(".$model->goods_id.")' class='btn btn-sm btn-warning marr5' >审核</a>";
                    }else{
                        return yii::$app->params['goods_status'][$model->status];
                    }
                    
                 },
                 'filter'=>Yii::$app->params['shops_status'],
            ],*/
            // 'status_info',
            // 'content:ntext',
            // 'mobile_content:ntext',
            'create_time:datetime',

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
