<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NewsCat */

$this->title = '新建栏目';
$this->params['breadcrumbs'][] = ['label' => '文章栏目', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-cat-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
