<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Article Cates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-cate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cate_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cate_id], [
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
            'cate_id',
            'name',
            'sort',
        ],
    ]) ?>

</div>
