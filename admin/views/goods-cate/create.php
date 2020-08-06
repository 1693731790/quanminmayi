<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = '添加类目';
$this->params['breadcrumbs'][] = ['label' => '商品分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/static/ColorAdmin/V2.1/css/style.min.css" rel="stylesheet">
<link href="/static/ColorAdmin/V2.1/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet">
<link href="/static/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="/static/sinian-backend/iconfont.css" rel="stylesheet">
<link href="/static/ColorAdmin/V2.1/css/animate.min.css" rel="stylesheet">
<link href="/static/ColorAdmin/V2.1/css/style-responsive.min.css" rel="stylesheet">
<link href="/static/ColorAdmin/V2.1/css/theme/default.css" rel="stylesheet">
<link href="/static/node_modules/element-ui/lib/theme-color/index.css" rel="stylesheet">
<link href="/css/site.css" rel="stylesheet">

<script src="/static/ColorAdmin/V2.1/plugins/pace/pace.min.js"></script>
<script src="/static/ColorAdmin/V2.1/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="/static/ColorAdmin/V2.1/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/ColorAdmin/V2.1/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/static/ColorAdmin/V2.1/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="/static/ColorAdmin/V2.1/js/apps.min.js"></script>
<script src="/static/node_modules/vue/dist/vue.js"></script>
<script src="/static/node_modules/element-ui/lib/index.js"></script>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
