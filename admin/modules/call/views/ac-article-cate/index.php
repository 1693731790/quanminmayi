<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleCateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '添加分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-cate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'cate_id',
            'name',
            //'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
