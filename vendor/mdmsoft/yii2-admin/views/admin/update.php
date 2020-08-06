<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Admin */

$this->title = '编辑管理员: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="admin-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
