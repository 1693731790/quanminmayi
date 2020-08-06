<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserLog */

$this->title = 'Update User Log: ' . $model->user_log_id;
$this->params['breadcrumbs'][] = ['label' => 'User Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_log_id, 'url' => ['view', 'id' => $model->user_log_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
