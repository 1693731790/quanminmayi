<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\JdConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '配置文件';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jd-config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php// Html::a('Create Jd Config', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'id',
            'label',
            'value',
            'type',
            'description',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
