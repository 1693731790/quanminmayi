<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AgentChannel */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '个人业绩奖配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-channel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
