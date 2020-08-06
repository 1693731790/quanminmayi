<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RechargeCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '充值卡列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recharge-card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            "batch_num",
            'card_num',
            'password',
             ['attribute'=>'is_use',
                'value'  => function($model){
                      return $model->is_use==1?"已使用":"未使用";
                 },
                 'filter'=>["1"=>"已使用","0"=>"未使用"],
            ],
            'fee',
            'create_time:datetime',
          	 ['attribute'=>'',
              	"label"=>"二维码",
				'format' => 'raw',              
                'value'  => function($model){
                      return "<span class='btn btn-success' onclick='showQrcode(".$model->id.")'>查看</span>";
                 },
                 
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',//
                'buttons'=>[
                   
                    'delete'=>function($url,$model){
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
                    },
                ],
               
            ],
        ],
    ]); ?>
</div>
<script>
  function showQrcode(id)
  {
    	layer.open({
            type: 2,
            title: '二维码',
            shadeClose: true,
            shade: 0.8,
            area: ['330px', '360px'],
            content: '<?=Url::to(["recharge-card/qrcode"])?>'+"?id="+id //iframe的url
       }); 
  }
</script>
