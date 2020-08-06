<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Express */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '快递列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="express-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'express_id',
            'name',
            'code',
        ],
    ]) ?>

</div>
