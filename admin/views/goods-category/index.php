<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goods Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cate_id',
            'pid',
            'name',
            'level',
            'sort',
            // 'cate_img',
            // 'adv_img',
            // 'adv_url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
