<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Nav;

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

    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    
    <!-- begin #page-container -->
    <div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
       

        <?=$this->render('top')?>
        <?=$this->render('left')?>
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
               
            <!-- end breadcrumb -->
            
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
    
                            </div>
                            <h4 class="panel-title"><?=Html::encode($this->title)?></h4>
                        </div>
                        <div class="panel-body">
                           <?=$content?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end #content -->
        
        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->
    

<?=$this->render('footer')?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
