<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AfOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="af-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
             ['attribute' => 'order_id',
                 
            'options'=>[
                    'width'=>'80',
                ],
            ],
            'order_sn',
            'total_fee',
            'goods_name',
            'num',
            ["attribute"=>"status",
             'format' => 'raw',
              "value"=>function($model){
                	if($model->status=="1")
                    {
                     	return "已上传支付凭证"; 
                    }else if($model->status=="0"){
                        return "未上传支付凭证--<a href='".Url::to(["order/pay","order_id"=>$model->order_id])."' class='btn btn-sm btn-warning marr5' >上传</a>";
                    }else if($model->status=="2"){
                        return "已发货";
                    }
                  
                }, 
               'filter'=>["0"=>"未上传支付凭证","1"=>"已上传支付凭证","2"=>"已发货"],
               'options'=>[
                    'width'=>'200',
                ],
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
                        }else{
                            return "";
                        }
                        
                    },
                    
                    
                ],
                'options'=>[
                    'width'=>'250',
                ],
            ],
        ],
    ]); ?>
</div>

<script>
  function orderstatus(order_id)
  {
      var url="<?=Url::to(['af-order/order-status'])?>"+"?order_id="+order_id;
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
