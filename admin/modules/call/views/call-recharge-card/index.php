<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RechargeCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电话充值卡列表';
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
			[
              	"attribute"=>"id",
              	'options'=>[
                    'width'=>'100',
                ],
            
            ],
          [
              	"attribute"=>"call_agent_id",
              	'options'=>[
                    'width'=>'100',
                ],
            
            ],
            [
              	"attribute"=>"batch_num",
              	'options'=>[
                    'width'=>'200',
                ],
            
            ],
          [
              	"attribute"=>"card_num",
              	'options'=>[
                    'width'=>'200',
                ],
            
            ],
          [
              	"attribute"=>"password",
              	'options'=>[
                    'width'=>'100',
                ],
            
            ],
           
            
             ['attribute'=>'is_use',
                'value'  => function($model){
                      return $model->is_use==1?"已使用":"未使用";
                 },
                 'filter'=>["1"=>"已使用","0"=>"未使用"],
              	'options'=>[
                    'width'=>'100',
                ],
            ],
          [
              	"attribute"=>"user_id",
              	'options'=>[
                    'width'=>'100',
                ],
            
            ],
          [
              	"attribute"=>"phone",
              	'options'=>[
                    'width'=>'150',
                ],
            
            ],
           [
              	"attribute"=>"fee",
              	'options'=>[
                    'width'=>'80',
                ],
            
            ],
           [
              	"attribute"=>"create_time",
             	"value"=>function($model){
                  	return date("Y-m-d H:i:s",$model->create_time);
                },
              	'options'=>[
                    'width'=>'200',
                ],
            
            ],
           [
              	"attribute"=>"end_time",
             "value"=>function($model){
                  	return date("Y-m-d H:i:s",$model->end_time);
                },
              	'options'=>[
                    'width'=>'200',
                ],
            
            ],
           
          /*	 ['attribute'=>'',
              	"label"=>"二维码",
				'format' => 'raw',              
                'value'  => function($model){
                      return "<span class='btn btn-success' onclick='showQrcode(".$model->id.")'>查看</span>";
                 },
                 
            ],*/
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
            content: '<?=Url::to(["call-recharge-card/qrcode"])?>'+"?id="+id //iframe的url
       }); 
  }
</script>
