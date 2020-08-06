<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CarLength */


if($model->type==2){
	$this->title = '添加整车车长';
	$this->params['breadcrumbs'][] = ['label' => '整车列表', 'url' => ['index']];
}
if($model->type==3){
	$this->title = '绿色通道添加车长';
	$this->params['breadcrumbs'][] = ['label' => '绿色通道整车列表', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-length-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
