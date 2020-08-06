<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdvSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '广告';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adv-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'adv_id',
             'name',
            
            
            ['attribute'=>'img',
                'format'=>'html',
                'value'=>function($model){
                    return Html::img($model->img,['width'=>110,'height'=>110]);
                },
            ],
            'url:ntext',
           

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
