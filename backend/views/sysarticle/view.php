<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sysarticle */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '系统文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sysarticle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->article_id], ['class' => 'btn btn-primary']) ?>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'article_id',
            'title',
            /*'title_img',
            'key',
            'desc',*/
            'content:ntext',
            'create_time:datetime',
        ],
    ]) ?>

</div>
