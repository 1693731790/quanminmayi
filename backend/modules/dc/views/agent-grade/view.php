<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AgentGrade */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Agent Grades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-grade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->grade_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->grade_id], [
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
            'grade_id',
            'name',
            'need_fee',
            'goods_card',
            'reward',
        ],
    ]) ?>

</div>
