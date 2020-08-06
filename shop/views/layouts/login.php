<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
//AppAsset::register($this);
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
	<link href="/library/ColorAdmin/V2.1/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="/library/ColorAdmin/V2.1/css/style.min.css" rel="stylesheet" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image">
                    <img src="/img/login-bg/bg-9.jpg" data-id="login-cover-image" alt="" />
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header">
                 <h1></h1>
                    <div class="brand text-center">
                        管理员登录
                    </div>

                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
				<?=$content?>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->
        
	</div>
	<!-- end page container -->
    
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/library/ColorAdmin/V2.1/plugins/jquery/jquery-1.9.1.min.js"></script>

	<script src="/library/ColorAdmin/V2.1/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="/library/ColorAdmin/V2.1/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
