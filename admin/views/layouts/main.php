<?php

use yii\helpers\Html;
use yii\helpers\Url;
use admin\assets\AppAsset;


AppAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"<
        <meta name="renderer" content="webkit">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title); ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini fixed" style="background:#fff">
    <?php $this->beginBody() ?>
    <div class="wrapper-content">
        <section class="content-header">
            <a href="<?= Yii::$app->request->getUrl(); ?>" class="rfHeaderFont">
                <i class="glyphicon glyphicon-refresh"></i> 刷新
            </a>
            <?php if (Yii::$app->request->referrer != Yii::$app->request->hostInfo . Yii::$app->request->getBaseUrl() . '/'){ ?>
                <a href="javascript:history.go(-1)" class="rfHeaderFont">
                    <i class="fa fa-mail-reply"></i> 返回
                </a>
            <?php } ?>
          
        </section>
        <section class="content">
            <?= $content; ?>
        </section>
      
    </div>
    <!-- 公用底部-->
      <script>
        // 配置
        let config = {
            tag: "false",
            
        };
    </script>
    <?= $this->render('_footer')?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>