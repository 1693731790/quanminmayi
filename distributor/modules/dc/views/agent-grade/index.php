<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AgentGradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '代理商升级配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-grade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'grade_id',
            'name',
          	'gt_num',
          'lt_num',
          'price',
           
          

             ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',//
                'buttons'=>[
                    
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>
