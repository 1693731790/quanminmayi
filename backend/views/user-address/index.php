<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserAddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户收货地址';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-address-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'aid',
            'user_id',
            'name',
            'phone',
            'region',
            'address',
            // 'isdefault',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
