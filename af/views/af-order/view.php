<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AfOrder */

$this->title = $model->order_sn;

?>
<div class="af-order-view">

    <h1>订单：<?= Html::encode($this->title) ?></h1>
<?php if($model->pay_img!="" && $model->status!="0"):?>
  <a href="<?=$model->pay_img?>" target="_blank" class="btn btn-success">查看汇款凭证</a>
<?php endif;?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'd_id',
            
            'order_sn',
            'total_fee',
            'goods_id',
            'goods_name',
            'num',
            'address_name',
            'address_phone',
            'address_region',
            
            'address_address',
          ['attribute' => 'status',
                 'value'  => function($model){
                   if($model->status=="1")
                   {
                     	return "已上传支付凭证"; 
                   }else if($model->status=="0"){
                    	return "未上传支付凭证"; 
                   }else if($model->status=="2"){
                    	return "已发货"; 
                   }
                    
                 },
               
            ],
           
          
           ['attribute' => 'pay_img',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'汇款凭证']],
                 'value'  => function($model){
                    return $model->pay_img;
                 },
               
            ],
            'remarks',
            'express_type',
            'express_num',
            'create_time:datetime',
        ],
    ]) ?>

</div>
