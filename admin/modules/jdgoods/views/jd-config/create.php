<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\JdConfig */

$this->title = 'Create Jd Config';
$this->params['breadcrumbs'][] = ['label' => 'Jd Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jd-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
