<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '代理商列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
			"id",
            'username',
            'realname',
            'corp_name',
            
           
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    
                    'view'=>function($url,$model){
                        return "<a class='btn btn-sm btn-info' onclick='selectUser(".$model->id.")'>选择</a>";
                        
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
  function selectUser(uid)
  {
    $(window.parent.document).find("#call_agent_id").val(uid);
    parent.layer.closeAll();
    
  }
</script>