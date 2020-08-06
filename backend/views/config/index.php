<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Config */

$this->title = '修改配置';
$this->params['breadcrumbs'][] = ['label' => '修改', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">

<div class="config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    
<div class="config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'web_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_describe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_call')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_copyright')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'confirm_order_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'home_show_special_num')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'signin_fee')->textInput(['maxlength' => true]) ?>
  
  <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>
  
  <?= $form->field($model, 'appapk_url')->textInput(['maxlength' => true]) ?>
     <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
               
                <input  id="photo_file_goods_thums"  type="file" multiple="true" value="" />
                        
            </div>
           
        </div>
    </div>
<script>

                        $("#photo_file_goods_thums").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'appapk'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传app',

                            'fileTypeExts': '*.apk',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#config-appapk_url").val(data);

                               

                            }

                        });

                    </script>
  
    <div class="form-group">
        <?= Html::submitButton('修改', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
