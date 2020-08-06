<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

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
            //'shop_id',
            //'goods_id',
            'total_fee',
            'deliver_fee',
            // 'address_id',
             
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
             
             'pay_time:datetime',
            // 'pay_num',
            // 'remarks',
            // 'is_comment',
            
            // 'refund_remarks',
            // 'is_settlement',
            // 'use_score',
            // 'get_score',
            // 'delivery_time:datetime',
            // 'receive_time:datetime',
            // 'create_time:datetime',

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
                        }else if($model->status=="4"){
                            if($model->refund_is_shop=="1")
                            {
                                return "<a class='btn btn-sm btn-warning marr5' >退款审核中</a>";
                            }else{
                                return "<a onclick='orderrefund(".$model->order_id.")' class='btn btn-sm btn-warning marr5' >确认退款</a>";    
                            }
                            
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
      var url="<?=Url::to(['order/order-status'])?>"+"?order_id="+order_id;
      layer.open({
        type: 2,
        title: '发货',
        shadeClose: true,
        shade: 0.8,
        area: ['30%', '50%'],
        content: url //iframe的url
      }); 
    
  }
  function orderrefund(order_id)
  {

     $.get("<?=Url::to(["order/crefund"])?>",{"order_id":order_id},function(r){
        if(r.success)
        {
            layer.msg(r.message);
            setTimeout(function(){window.location.reload()},2000);
        }else{
            layer.msg(r.message);
        }
     },'json')
    
  }
  
</script>