<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserBank */

$this->title = '修改: ' . $model->bank_id;
$this->params['breadcrumbs'][] = ['label' => '修改', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bank_id, 'url' => ['view', 'id' => $model->bank_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="user-bank-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
