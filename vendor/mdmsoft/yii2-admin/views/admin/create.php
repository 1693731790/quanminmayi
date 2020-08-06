<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Admin */

$this->title = '新增管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
