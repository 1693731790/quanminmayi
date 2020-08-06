<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DistributorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '经销商列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributor-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'd_id',
            'user_id',
            'name',
            'id_num',
             'phone',
            
            
            
             ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',//
                'buttons'=>[
                    'view'=>function($url,$model){
                        return "<a class='btn btn-sm btn-info' onclick='select(".$model->d_id.")'>选择</a>";
                        
                    },
                ],
                'options'=>[
                    'width'=>'100',
                ],
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
  function select(uid)
  {
	$(window.parent.document).find("#distributor_id").val(uid);  
 
    
    parent.layer.closeAll();
    
  }
</script>