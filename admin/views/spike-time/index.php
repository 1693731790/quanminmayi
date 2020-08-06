<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SpikeTimeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '时间';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spike-time-index">

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

            'id',
            'hour',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
