<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Adv */

$this->title = '修改: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '广告', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->adv_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="adv-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
