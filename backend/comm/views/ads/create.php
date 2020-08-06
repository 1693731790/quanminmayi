<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Ads */

$this->title = '新建广告';
$this->params['breadcrumbs'][] = ['label' => '广告列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
