<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ShopsBannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'banner';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shops-banner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           

            'banner_id',
            
            ['attribute' => 'img',
                 
                 'format' => ['image',['width'=>'300','height'=>'110']],
                 'value'  => function($model){
                    return $model->img;
                 }
            ],
            'url:url',
            'orderby',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
