<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sysarticle */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '系统文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sysarticle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
