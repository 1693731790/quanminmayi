<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSeckillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '秒杀订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-seckill-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

           'order_id',
            'user_id',
            'order_sn',
            'total_fee',
            
           
            ['attribute'=>'status',
                'value'=>function($model){
                    
                        return Yii::$app->params['order_status'][$model->status];
                   
                    
                },
              'filter'=>Yii::$app->params['order_status'],
            ],
           ['attribute'=>'pay_type',
                'value'=>function($model){
                    return $model->pay_type!=""?Yii::$app->params['pay_method'][$model->pay_type]:"未设置";
                },
              'filter'=>Yii::$app->params['pay_method'],
            ],
             
             'create_time:datetime',

           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{status}',//{delete}
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'status'=>function($url,$model){
                        if($model->status=="1")
                        {
                            return "<a onclick='orderstatus(".$model->order_id.")' class='btn btn-sm btn-warning marr5' >发货</a>";
                        }else if($model->status=="4")
                        {

                            return "<a onclick='orderRefund(".$model->order_id.")' class='btn btn-sm btn-warning marr5' >确认退款</a>";
                        }else{
                            return "";
                        }
                        
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


<script type="text/javascript">
  function orderstatus(order_id)
  {
      var url="<?=Url::to(['order-seckill/order-status'])?>"+"?order_id="+order_id;
      layer.open({
        type: 2,
        title: '发货',
        shadeClose: true,
        shade: 0.8,
        area: ['30%', '50%'],
        content: url //iframe的url
      }); 
    
  }

  function orderRefund(order_id)
  {
      var url="<?=Url::to(['order-seckill/order-refund'])?>"+"?order_id="+order_id;
      layer.open({
        type: 2,
        title: '退款审核',
        shadeClose: true,
        shade: 0.8,
        area: ['30%', '50%'],
        content: url //iframe的url
      }); 
    
  }
</script>
