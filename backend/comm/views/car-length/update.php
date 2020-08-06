<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CarLength */

if($model->type==2){
	$this->title = '整车编辑: ' . $model->id;
	$this->params['breadcrumbs'][] = ['label' => '整车列表', 'url' => ['index']];
	$this->params['breadcrumbs'][] = '编辑';
}
if($model->type==3){
	$this->title = '绿色通道编辑: ' . $model->id;
	$this->params['breadcrumbs'][] = ['label' => '绿色通道整车列表', 'url' => ['index']];
	$this->params['breadcrumbs'][] = '绿色通道编辑';
}


?>
<div class="car-length-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
