<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Nav;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\NavBar;
use backend\widgets\Breadcrumbs;
use common\widgets\Alert;
use dmstr\widgets\Menu;
use backend\assets\ColorAdminAsset;
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

   
    <!-- end page container -->
    


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
