<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MobileCardImgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电话卡封面';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mobile-card-img-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'mi_id',
            'title',
             ['attribute'=>'img',
                'format'=>'html',
                'value'=>function($model){
                    return Html::img($model->img,['width'=>110,'height'=>110]);
                },
            ],

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