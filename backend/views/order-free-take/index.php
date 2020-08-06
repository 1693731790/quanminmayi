<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderFreeTakeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '免费拿订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-free-take-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
			'order_id',
          	 ['attribute' => 'goods_thums',
                 'label' => '商品主图',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'商品图片']],
                 'value'  => function($model){
                    return $model->goods_thums;
                 }
            ],
            'user_id',
            'order_sn',
            'user_num',
            'get_user_num',
            'goods_id',
            'goods_name',
            
            // 'address_name',
            // 'address_phone',
            // 'address_region',
            // 'address_region_id',
            // 'address_address',
            ['attribute'=>'status',
                'value'=>function($model){
                    return Yii::$app->params['order_free_take_status'][$model->status];
                    
                    
                },
              'filter'=>Yii::$app->params['order_free_take_status'],
            ],
            // 'remarks',
            // 'is_comment',
            // 'express_type',
            // 'express_num',
             'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{status}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                   'status'=>function($url,$model){
                        if($model->status=="1")
                        {
                            return "<a onclick='orderstatus(".$model->order_id.")' class='btn btn-sm btn-warning marr5' >发货</a>";
                        }
                        
                    },
                    
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>



<script type="text/javascript">
  function orderstatus(order_id)
  {
      var url="<?=Url::to(['order-free-take/order-status'])?>"+"?order_id="+order_id;
      layer.open({
        type: 2,
        title: '发货',
        shadeClose: true,
        shade: 0.8,
        area: ['30%', '50%'],
        content: url //iframe的url
      }); 
    
  }

 
</script>
