<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MobileCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电话卡类型列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mobile-card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加电话卡类型', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'mid',
            'name',
             ['attribute'=>'title_pic',
                'format'=>'html',
                'value'=>function($model){
                    return Html::img($model->title_pic,['width'=>110,'height'=>110]);
                },
            ],
            'desc',
            'create_time:datetime',

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
