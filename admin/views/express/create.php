<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Express */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '快递列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="express-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
