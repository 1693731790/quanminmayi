<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AgentChannel */

$this->title = '修改: ' . $model->channel_id;
$this->params['breadcrumbs'][] = ['label' => '个人业绩奖配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->channel_id, 'url' => ['view', 'id' => $model->channel_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="agent-channel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
