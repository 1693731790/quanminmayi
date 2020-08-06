<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '店铺列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shops-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加店铺', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'shop_id',
            'user_id',
          //  'shop_sn',
            'name',
            //'desc',
            'truename',
            // 'id_front',
            // 'id_back',
           //  'img',
             'tel',
            // 'address',
            // 'level',
            // 'notice',
             'browse',
            // 'delivery_time',
            // 'status',
             'create_time:datetime',
             ['attribute'=>'status',
               'label' => '审核状态',
                 'format' => 'raw',
                 'value'  => function($model){
                    if($model->status=="0")
                    {
                        return "<a onclick='status(".$model->shop_id.")' class='btn btn-sm btn-warning marr5' >审核</a>";
                    }else{
                        return yii::$app->params['shops_status'][$model->status];
                    }
                    
                 },
                  'filter'=>Yii::$app->params['shops_status'],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}',//{delete}
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    /*'delete'=>function($url,$model){
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
                    },*/
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
  
    function status(id)
    {

        layer.open({
          type: 2,
          title: '审核店铺',
          shadeClose: true,
          shade: 0.8,
          area: ['500px', '60%'],
          content: "/shops/status?id="+id //iframe的url
        }); 
    }
</script>