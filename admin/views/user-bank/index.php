<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户银行卡';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-bank-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'bank_id',
            'user_id',
            'name',
            'bank_name',
            'account',
            'phone',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
