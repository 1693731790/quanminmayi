<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AgentGrade */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-grade-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
