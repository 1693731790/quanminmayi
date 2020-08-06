<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Special */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Specials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->special_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->special_id], [
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
            'special_id',
            'goods_id',
            'name',
            'img',
            'content:ntext',
            'create_time:datetime',
        ],
    ]) ?>

</div>
