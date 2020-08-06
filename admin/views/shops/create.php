<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Shops */

$this->title = '添加店铺';
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shops-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
