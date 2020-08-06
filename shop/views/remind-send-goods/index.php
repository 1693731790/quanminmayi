<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RemindSendGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提醒发货列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="remind-send-goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user_id',
            //'shop_id',
            'order_id',
            'create_time:datetime',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
