<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Special */

$this->title = '修改: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '专题列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->special_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="special-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
