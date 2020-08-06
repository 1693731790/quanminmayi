<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Distributor */

$this->title = '修改: ' . $model->name;

?>
<div class="distributor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
