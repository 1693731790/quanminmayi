<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Supplier */

$this->title = '修改: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '供货商', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];

?>
<div class="supplier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
