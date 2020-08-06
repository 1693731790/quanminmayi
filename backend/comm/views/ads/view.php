<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ads */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '广告列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->ads_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['remove', 'id' => $model->ads_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ads_id',
            'name',
            'data:ntext',
            'sort',
            'images:ntext',
            'remark',
            'create_time:datetime',
            'update_time:datetime',
            'is_delete',
        ],
    ]) ?>

</div>
